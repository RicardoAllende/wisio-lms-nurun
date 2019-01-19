<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\Ascription;
use App\Notification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\FakerMail;
use App\Mail\Test;
use AWS;

class FakerMailController extends Controller
{

    public $maxMonthReminders = 2; // max: 2 mails
    public $maxWeekReminders = 4; // max: 4 mails
    
    public function sendEmail(){
        if(config('settings.mailing')){
            $weekAgo = Carbon::now()->subweek();
            $monthAgo = Carbon::now()->submonth(); // 30 days ago
            foreach(Course::cursor() as $course){
                $users = $course->incompleteUsers()->cursor();
                foreach($users as $element){
                    $user = User::find($element->user_id);
                    if($user->enabled){
                        $lastAdvance = $user->lastAdvanceInCourse($course->id); // Timestamp
                        if( ! $user->hasCallNotification()){
                            if($user->hasNotificationsFromCourse($course->id)){
                                $lastNotification = $user->lastNotificationFromCourse($course->id);
                                $timestampLastNotification = $lastNotification->created_at;
                                $notificationType = $lastNotification->type;
                                if($lastAdvance->gt($timestampLastNotification)){ // Doctor had advance in the course after the notification, mailing is every month
                                    // echo "Tiene notificación anterior, CON avance<br>";
                                    if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, month reminder
                                        $this->sendMonthReminderNotification($user->email, $user->id, $user->ascription->name, $course->id);                            
                                    }
                                }else{ // Doctor didn't have advance  
                                    if($notificationType == 'month_reminder'){
                                        if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, month reminder
                                            $numMonthReminders = $numMonthReminders = $user->numMonthReminderNotifications($course->id);
                                            if($numMonthReminders < $this->maxMonthReminders){
                                                $this->sendMonthReminderNotification($user->email, $user->id, $user->ascription->name, $course->id);
                                            }else{
                                                $this->sendWeekReminderNotification($user->mobile_phone, $user->id, $user->ascription->name, $course->id);
                                            }
                                        }
                                    }elseif($notificationType == 'week_reminder'){
                                        // echo "Semanal {$user->id}<br>";
                                        $numWeekReminders = $user->numWeekReminderNotifications($course->id);
                                        if($timestampLastNotification->lt($weekAgo)){ // More than 1 week without advance, month remind
                                            // echo "Notificación semanal";
                                            if($numWeekReminders < $this->maxWeekReminders){
                                                // echo "Total: {$numWeekReminders}, máximo: {$this->maxWeekReminders} <br>";
                                                $this->sendWeekReminderNotification($user->mobile_phone, $user->id, $user->ascription->name, $course->id);
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
                            }else{ // First Notification
                                if($monthAgo->gt($lastAdvance)){ // More than 1 month without advance, month reminder
                                    $this->sendMonthReminderNotification($user->email, $user->id, $user->ascription->name, $course->id);
                                }
                            }
                        }else{ // User has call notification from course
                            // echo "Usuario está en lista de llamada<br>";
                        }

                    }
                }
            }
        }
        return Carbon::now();
    }

    public function sendMonthReminderNotification($email, $user_id, $ascription_name, $course_id){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 2]);
        $urlLogin = route('ascription.login', $ascription_name)."?notification=".$token;
        return $urlLogin;
        FakerMail::create(['email' => $email, 'type' => 'month_reminder', 'link' => route('login')."?notification=".$token]);
        return true;
    }

    public function sendWeekReminderNotification($mobilePhone, $user_id, $ascription_name, $course_id){ // This function sends a sms
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 3]);
        $urlLogin = route('ascription.login', $ascription_name)."?notification=".$token;
        return $urlLogin;
        FakerMail::create(['email' => $email, 'type' => 'week_reminder', 'link' => route('login')."?notification=".$token]);
        return;

        $sms = AWS::createClient('sns');
        $sms->publish([
                'Message' => 'Mensaje de prueba desde enviado por el sistema academia mc',
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
        FakerMail::create(['email' => $email, 'type' => 'recommendation', 'link' => route('login')."?notification=".$token]);
        return;
    }

    public function addToListOfUsersToCall($user_id, $course_id){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 4]);
    }

    public function sendTestEmail(){
        $email = "ricardo.allende.p@gmail.com";
        // from is in Test class
        Mail::to($email)->send(new Test());
        echo "Email enviado a {$email} <br>";
        $email = "ricardo.allende@subitus.com";
        Mail::to($email)->send(new Test());
        echo "Email enviado a {$email} <br>";
        return "Test sendTestEmail terminado";
    }

    public function sendTestEmailTo($email){
        Mail::to($email)->send(new Test());
        echo "Email enviado a {$email} <br>";
        return "Test sendTestEmailTo terminado";
    }

    public function sendTestSMS(){
        $mobilePhone = "5525731520";
        $sms = AWS::createClient('sns');
        // dd($sms);
        $sms->publish([
                'Message' => 'Mensaje de prueba',
                'PhoneNumber' => $mobilePhone,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType'  => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                     ]
            	 ],
              ]);
        return "Mensaje enviado a {$mobilePhone}";
    }

    public function sendTestSMSTo($mobilePhone){
        $sms = AWS::createClient('sns');
        $sms->publish([
                'Message' => 'Mensaje de prueba enviad',
                'PhoneNumber' => $mobilePhone,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType'  => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                     ]
            	 ],
              ]);
    }

}
