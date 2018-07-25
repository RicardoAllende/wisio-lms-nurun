<?php

namespace App\Http\Controllers;

use Illuminate\Console\Command;
use App\Course;
use App\User;
use App\Ascription;
use App\Notification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Setting;
use App\Mail\MonthReminder;
use App\Mail\Test;
use App\Mail\Welcome;
use App\Mail\NewPlatform;
use App\Mail\Recordatorio;
use App\Mail\Recordatorio2;
use AWS;
use Illuminate\Support\Facades\DB;

class FakerMailController extends Controller
{

    public $maxMonthReminders = 2; // default if database doesn't have value
    public $maxWeekReminders = 4; // default if database doesn't have value
    public $mailing = false;
    public $maxSMSReminders =2;
    
    public function sendEmail(){
        $time_start = $this->microtime_float();
        $settings = Setting::first();
        $invitation_sent = true; // default value
        if($settings != null){
            $monthReminders = $settings->maxMonthReminders;
            if(is_numeric($monthReminders)){
                $this->maxMonthReminders = $monthReminders;
            }
            $weekReminders = $settings->maxWeekReminders;
            if(is_numeric($weekReminders)){
                $this->maxWeekReminders = $weekReminders;
            }
            $maxSMSReminders = $settings->maxSMSReminders;
            if(is_numeric($maxSMSReminders)){
                $this->maxSMSReminders = $maxSMSReminders;
            }
            $this->mailing = $settings->mailing; // true | false
            $invitation_sent = $settings->invitation_sent;
        }

        set_time_limit(1500);
        if( ! $invitation_sent){ // Invitations haven't sent, 
            $settings->invitation_sent = true;
            $settings->save();
            $ascriptions = Ascription::cursor();
            foreach($ascriptions as $ascription){
                $route = route('ascription.login', $ascription->slug);
                $users = $ascription->users()->cursor();
                foreach($users as $user){
                    Mail::to($user->email)->send(new NewPlatform($user->full_name, $route));
                }
            }
            return;
        }else{
            if($this->mailing){
                $weekAgo = Carbon::now()->subweek();
                $monthAgo = Carbon::now()->submonth(); // 30 days ago
                foreach(Course::cursor() as $course){
                    $users = $course->incompleteUsers()->where('users.enabled', 1)->cursor();
                    foreach($users as $element){
                        $user = User::find($element->user_id);
                        $lastAdvance = $user->lastAdvanceInCourse($course->id); // Timestamp
                        if( ! $user->hasCallNotification($course->id)){
                            // echo "{$course->id}/ ";
                            if($user->hasNotificationsFromCourse($course->id)){
                                $lastNotification = $user->lastNotificationFromCourse($course->id);
                                $timestampLastNotification = $lastNotification->created_at;
                                $notificationType = $lastNotification->type;
                                // echo "{$course->id}& ";
                                if($lastAdvance->gt($timestampLastNotification)){ // Doctor had advance in the course after the notification, mailing is every month
                                    // echo "--c{$course->id}u{$user->id}--";
                                    // echo "Tiene notificación anterior, CON avance<br>";
                                    if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, month reminder
                                        $this->sendMonthReminderNotificationWithAdvance($user->email, $user->id, $user->slug, $course->id, $course->name,
                                        $user->full_name, $course->credits, $course->modules()->count(), $user->numCompletedModulesOfCourse($course->id));
                                    }
                                }else{ // Doctor didn't have advance 
                                    if( $user->inSMSList($course->id)){
                                        // $lastNotification = $user->lastNotificationFromCourse($course->id);
                                        // $timestampLastNotification = $lastNotification->created_at;
                                        // $notificationType = $lastNotification->type;
                                        
                                        echo " u{$user->id}c{$course->id} ";
                                        // echo "<br>Sin avance {$user->id}, curso {$course->id}<br>";
                                        // return "En lista de sms {$user->id}, curso {$course->id}";
                                        if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, send sms

                                            if($user->numSMSForCourse($course->id) < $this->maxSMSReminders){
                                                $this->sendSMS($user->mobilePhone, $user->id, $user->ascription->slug, $course->id, $user->full_name, $course->name, $course->credits);
                                            }else{
                                                // journey finished
                                                echo "Finalizado";
                                            }
                                        }else{
                                            echo "Siguiente mes";
                                            // send message next month
                                        }
                                    }else{ 
                                        if($notificationType == 'month_reminder'){
                                            if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, month reminder
                                                $numMonthReminders = $numMonthReminders = $user->numMonthReminderNotifications($course->id);
                                                if($numMonthReminders < $this->maxMonthReminders){
                                                    $this->sendMonthReminderNotification($user->email, $user->id, $user->slug, $course->id);
                                                }else{
                                                    $this->sendWeekReminderNotification(
                                                        $user->email, $user->id, $user->slug, $course->id, 
                                                        $course->name, $user->full_name, $course->credits
                                                    );
                                                    // $this->sendWeekReminderNotification($user->mobile_phone, $user->id, $user->slug, $course->id);
                                                }
                                            }
                                        }elseif($notificationType == 'week_reminder'){
                                            // echo "Semanal {$user->id}<br>";
                                            $numWeekReminders = $user->numWeekReminderNotifications($course->id);
                                            if($timestampLastNotification->lt($weekAgo)){ // More than 1 week without advance, month remind
                                                // echo "Notificación semanal";
                                                if($numWeekReminders < $this->maxWeekReminders){
                                                    $this->sendWeekReminderNotification(
                                                        $user->email, $user->id, $user->slug, $course->id, 
                                                        $course->name, $user->full_name, $course->credits
                                                    );
                                                }else{
                                                    // echo "Agregando a la lista de personas por llamar<br>";
                                                    $this->addToListOfUsersToCall($user->id, $course->id);
                                                }
                                            }else{
                                                if($numWeekReminders == $this->maxWeekReminders){
                                                    $this->addToListOfUsersToCall($user->id, $course->id);
                                                }
                                            }
                                        }
                                    }
                                }
                            }else{ // First Notification
                                if($monthAgo->gt($lastAdvance)){ // More than 1 month without advance, month reminder
                                    $this->sendMonthReminderNotificationWithAdvance($user->email, $user->id, $user->ascription->slug, $course->id, $course->name,
                                        $user->full_name, $course->credits, $course->modules()->count(), $user->numCompletedModulesOfCourse($course->id));
                                }
                            }
                        }else{ // User has call notification from course
                            // echo "u{$user->id}c{$course->id} ";
                            // echo "call{$course->id} ";
                            // echo "Usuario está en lista de llamada<br>";
                        }
                    } // end foreach users
                } // end foreach course
            }else{
                return "No está activado el envío de notificaciones";
            }
        }
        $time_end = $this->microtime_float();
        $time = $time_end - $time_start;
        return "Script terminado en {$time} segundos ";
        // return Carbon::now();
        return;
    }

    public function sendMonthReminderNotification($email, $user_id, $ascription_slug, $course_id){
        $email = 'ricardo.allende.p@gmail.com';
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 2]);
        $route = route('ascription.login', $ascription_slug)."?notification=".$token;
        Mail::to($email)->send(new Recordatorio($route));
        return true;
    }

    public function sendMonthReminderNotificationWithAdvance($email, $user_id, $ascription_slug, $course_id, $course_name, $user_name, $credits, $numModules, $numCompletedModules){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 2]);
        $route = route('ascription.login', $ascription_slug)."?notification=".$token;
        Mail::to($email)->send(new MonthReminder($route, $course_name, $user_name, $credits, $numModules, $numCompletedModules));
        return true;
    }

    public function sendWeekReminderNotification($email, $user_id, $ascription_slug, $course_id, $course_name, $user_name, $credits){
        $email = 'ricardo.allende.p@gmail.com';
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 'week_reminder']);
        $route = route('ascription.login', $ascription_slug)."?notification=".$token;
        Mail::to($email)->send(new Recordatorio2($route, $user_name, $credits, $course_name));
        // Mail::to($email)->send(new MonthReminder($route, $course_name, $user_name, $credits, $numModules, $numCompletedModules));
        return true;
    }



    

    public function sendSMS($mobilePhone, $user_id, $ascription_slug, $course_id, $user_name, $course_name, $credits){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 'sms']);
        $mobilePhone = str_replace(' ', '', $mobilePhone);
        if(strpos($mobilePhone, '+52') !== false ){ // Found
            $mobilePhone = "+52".$mobilePhone;
        }
        $url = route('ascription.login', $ascription_slug)."?notification=".$token;
        return;
        $sms = AWS::createClient('sns');
        $sms->publish([
                'Message' => "Dr. ".$user_name.", no deje pasar la oportunidad de actualizar sus conocimientos con el curso de ".$course_name." que cuenta con ".$credits." puntos de valor curricular.
                ¡Dé clic en la liga para continuar su capacitación! \n ".$url,
                'PhoneNumber' => $mobilePhone,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType'  => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                     ]
            	 ],
              ]);
    }

    public function sendRecommendation($user){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 1]);
        return true;
        $token = \Uuid::generate()->string;
        return;
    }

    public function addToListOfUsersToCall($user_id, $course_id){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 4]);
    }



    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    function test(){
        $email = "ricardo.allende.p@gmail.com";
        $route = "http://dev.academia.sanofi/academia-mc/login?notification=412j3klfd";
        $full_name = "Ricardo Allende";
        $user_name = $full_name;
        $course_name = "Diabetes";
        $credits = 32;
        $numModules = 10;
        $numCompletedModules = 5;
        Mail::to($email)->send(new NewPlatform($full_name, $route));
        Mail::to($email)->send(new Recordatorio($route));
        Mail::to($email)->send(new Recordatorio($route));
        Mail::to($email)->send(new MonthReminder($route, $course_name, $user_name, $credits, $numModules, $numCompletedModules));
        Mail::to($email)->send(new Recordatorio2($route, $user_name, $credits, $course_name));
        return "Proceso terminado";
    }
}
