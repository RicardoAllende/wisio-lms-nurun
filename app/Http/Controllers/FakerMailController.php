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
        $courses = Course::all();
        $weekAgo = Carbon::now()->subweek();
        $monthAgo = Carbon::now()->submonth(); // 30 days ago
        echo "Week ago = {$weekAgo}, Month ago = {$monthAgo} <br>";
        foreach(Course::cursor() as $course){
            $users = $course->incompleteUsers()->cursor();
            foreach($users as $element){
                $user = User::find($element->user_id);
                $lastAdvance = $user->lastAdvanceInCourse($course->id); // Timestamp
                if( ! $user->hasCallNotification()){
                    if($user->hasNotificationsFromCourse($course->id)){
                        // echo "Tiene notificación anterior<br>";
                        $lastNotification = $user->lastNotificationFromCourse($course->id);
                        $timestampLastNotification = $lastNotification->created_at;
                        $notificationType = $lastNotification->type;
                        if($lastAdvance->gt($timestampLastNotification)){ // Doctor had advance in the course after the notification, mailing is every month
                            echo "Tiene notificación anterior, CON avance<br>";
                            if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, month reminder
                                $this->sendMonthReminderNotification($user->email, $user->id,  $course->id);
                                echo "Enviando nuevo mail a {$user->email}, está teniendo avance <br>";
                            }
                        }else{ // Doctor didn't hñave advance
                            // echo "Tiene notificación anterior, SIN avance<br>";
                            if($lastNotification->viewed == 1){
                                echo "Ubicación 66<br>";
                                
                                // $this->sendMonthReminderNotification($user->email, $user->id,  $course->id);
                                // echo "Enviando nuevo mail a {$user->mail}, está teniendo avance <br>";
                            }else{
                                if($notificationType == 'month_reminder'){
                                    if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, month reminder
                                        $numMonthReminders = $numMonthReminders = $user->numMonthReminderNotifications($course->id);
                                        if($numMonthReminders <= $this->maxMonthReminders){
                                            echo "Seending line 55<br>";
                                            $this->sendMonthReminderNotification($user->email, $user->id,  $course->id);
                                        }else{
                                            echo "Seendig in line 57<br>";
                                            $this->sendWeekReminderNotification($user->mobile_phone, $user->id, $course->id);
                                        }
                                    }
                                }elseif($notificationType == 'week_reminder'){
                                    if($timestampLastNotification->lt($weekAgo)){ // More than 1 month without advance, month remind
                                        $numWeekReminders = $user->numWeekReminderNotifications($course->id);
                                        if($numWeekReminders <= $this->maxWeekReminders){
                                            echo "Total: {$numWeekReminders}, máximo: {$this->maxWeekReminders} <br>";
                                            $this->sendWeekReminderNotification($user->mobile_phone, $user->id, $course->id);
                                        }else{
                                            echo "Agregando a la lista de personas por llamar<br>";
                                            $this->addToListOfUsersToCall($user->id, $course->id);
                                        }
                                    }
                                }
                            }
                        }
                    }else{ // First Notification
                        // echo "No tiene notificación<br>";
                        if($monthAgo->gt($lastAdvance)){ // More than 1 month without advance, month reminder
                            $this->sendMonthReminderNotification($user->email, $user->id,  $course->id);
                        }
                    }
                }else{
                    echo "Usuario esttá en lista de llamada<br>";
                }

            }
        }
        // echo "</table>";
        dd(Carbon::now());
        echo "Función terminada ";
    }

    public function sendMonthReminderNotification($email, $user_id,  $course_id){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 2]);
        return true;
        FakerMail::create(['email' => $email, 'type' => 'month_reminder', 'link' => route('login')."?notification=".$token]);
        return true;
    }

    public function sendWeekReminderNotification($mobilePhone, $user_id,  $course_id){ // This function sends a sms
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 3]);
        return true;
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

    public function sendRecommendation(){
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
        Mail::to($email)->send(new Test());
        echo "Email enviado a {$email} <br>";
        $email = "ricardo.allende@subitus.com";
        Mail::to($email)->send(new Test());
        echo "Email enviado a {$email} <br>";
        $email = "richard.kuishi@gmail.com";
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
        $sms->publish([
                'Message' => 'Mensaje de prueba enviado por el sistema academia mc',
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
                'Message' => 'Mensaje de prueba enviado por el sistema academia mc',
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
