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

class FakerMailController extends Controller
{

    public function sendEmail(){
        $courses = Course::all();
            // echo "<style>table {
            //     border: #b2b2b2 1px solid;
            // }
            // td {
            //     border: black 1px solid;
            // }
            // table {
            //     border-collapse: collapse;
            // }</style>";
            // echo "<table style='border: 1px solid black;' >";
            // echo "<tr>";
            // echo "<td>Se envía o no recordatorio</td>";
            // echo "<td>Correo Electrónico</td>";
            // echo "<td>Nombre del curso</td>";
            // echo "<td>Último avance en el curso</td>";
            // echo "<td>Un mes antes</td>";
            // // echo "Enviando recordatorio mensual a {$user->email}, del curso << {$course->name} >>, último avance << {$lastAdvance} >>, fecha de hace un mes: << {$monthAgo} >> <br>";
            // echo "</tr>";
        foreach(Course::cursor() as $course){
            $users = $course->incompleteUsers()->cursor();
            foreach($users as $element){
                $user = User::find($element->user_id);
                $lastAdvance = $user->lastAdvanceInCourse($course->id); // Timestamp
                if($user->hasNotificationsFromCourse($course->id)){
                    $lastNotification = $user->lastNotificationFromCourse($course->id);
                    $timestampLastNotification = $lastNotification->created_at;
                    if($lastAdvance->gt($lastNotification->created_at)){ // Doctor had advance in the course after the notification, mailing is every month
                        if($lastNotification->viewed == 1){ // Doctor followed the link
                            if($lastNotification->type == 'month_reminder'){
                                $monthAgo = Carbon::now()->submonth(); // 30 days ago
                                if($timestampLastNotification->gt($monthAgo)){
                                    // echo "Enviando recordatorio mensual a {$user->email} <br>";
                                    $this->sendMonthReminderNotification($user->email, $course->id);
                                }
                            }else if($lastNotification->type == 'week_reminder'){
                                $numWeekReminders = $user->numWeekReminderNotifications($course->id);
                                if($numWeekReminders < $this->maxWeekReminders){
                                    $weekAgo = Carbon::now()->subweek();
                                    if($timestampLastNotification->gt($weekAgo)){
                                        // echo "Enviando recomendación semanal a {$user->email} <br>";
                                        $this->sendWeekReminderNotification($user->mobile_phone, $course->id);
                                    }
                                }else{
                                    $this->addToListOfUsersToCall($user->id, $course->id);
                                    if($user->hasAvailableAnotherCourse()){
                                        // echo "Enviando recomendación a {$user->mail} <br>";
                                        $this->sendRecommendation();
                                    }else{
                                        // Ends the Mailing service
                                    }
                                }
                            }
                        }else{ // Doctor didn't follow the link
                            $numMonthReminders = $user->numMonthReminderNotifications($course->id);
                            if($numMonthReminders < $this->maxMonthReminders){
                                $this->sendMonthReminderNotification($user->email, $course);
                            }else{
                                // $this->sendWeekReminderNotification($user->mobile_phone, $route);
                            }
                            // Actions when user hasn't attend the notification
                        }
                    }else{ // User didn't have advance

                    }
                }else{ // First Notification
                    $monthAgo = Carbon::now()->submonth(); // 30 days ago
                    if($monthAgo->gt($lastAdvance)){ // More than 1 month without advance, month reminder
                        $this->sendMonthReminderNotification($user->email, $course->id);
                    }
                        // if($monthAgo->gt($lastAdvance)){ // More than 1 month without advance, month reminder
                        //     echo "<tr>";
                        //     echo "<td>Recordatorio mensual</td>";
                        //     echo "<td>{$user->email}</td>";
                        //     echo "<td>{$course->name}</td>";
                        //     echo "<td>{$lastAdvance}</td>";
                        //     echo "<td>{$monthAgo}</td>";
                        //     // echo "Enviando recordatorio mensual a {$user->email}, del curso << {$course->name} >>, último avance << {$lastAdvance} >>, fecha de hace un mes: << {$monthAgo} >> <br>";
                        //     echo "</tr>";
                        // }else{
                        //     echo "<tr>";
                        //     echo "<td>Sin ningún problema</td>";
                        //     echo "<td>{$user->email}</td>";
                        //     echo "<td>{$course->name}</td>";
                        //     echo "<td>Diferencia: ".$monthAgo->diffInDays($lastAdvance)." ?? {$lastAdvance}</td>";
                        //     echo "<td>{$monthAgo}</td>";
                        //     // echo "Enviando recordatorio mensual a {$user->email}, del curso << {$course->name} >>, último avance << {$lastAdvance} >>, fecha de hace un mes: << {$monthAgo} >> <br>";
                        //     echo "</tr>";
                        // }
                }

            }
        }
        // echo "</table>";
        echo "Función terminada";
    }

    public function sendMonthReminderNotification($email, $course_id){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 2]);
        return true;
        FakerMail::create(['email' => $email, 'type' => 'month_reminder', 'link' => route('login')."?notification=".$token]);
        return true;
    }

    public function sendWeekReminderNotification($mobilePhone, $course_id){ // This function sends a sms
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 3]);
        return true;
        FakerMail::create(['email' => $email, 'type' => 'week_reminder', 'link' => route('login')."?notification=".$token]);
        return;

        $sms = AWS::createClient('sns');
        $sms->publish([
                'Message' => 'Hello, This is just a test Message',
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
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 3]);
    }
}
