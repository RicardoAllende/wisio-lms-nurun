<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Course;
use App\User;
use App\Ascription;
use App\Notification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\FakerMail;

class CronMailing extends Command
{
    public $maxMonthReminders = 2;
    public $maxWeekReminders = 4;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Mailing:academia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mailing service Academia Sanofi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time_start = $this->microtime_float();
        $settings = Setting::first();
        if($settings != null){
            $monthReminders = $settings->maxMonthReminders;
            if(is_numeric($monthReminders)){
                $this->maxMonthReminders = $monthReminders;
            }
            $weekReminders = $settings->maxWeekReminders;
            if(is_numeric($weekReminders)){
                $this->maxWeekReminders = $weekReminders;
            }
            $this->mailing = $settings->mailing; // true | false
        }

        set_time_limit(1500);
        if($this->mailing){
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
                                        $this->sendMonthReminderNotification($user->email, $user->id, $user->ascription->name, $course->id, $course->name,
                                         $user->full_name, $course->credits, $course->modules()->count(), $user->numCompletedModulesOfCourse($course->id));                           
                                    }
                                }else{ // Doctor didn't have advance  
                                    if($notificationType == 'month_reminder'){
                                        if($timestampLastNotification->lt($monthAgo)){ // More than 1 month without advance, month reminder
                                            $numMonthReminders = $numMonthReminders = $user->numMonthReminderNotifications($course->id);
                                            if($numMonthReminders < $this->maxMonthReminders){
                                                $this->sendMonthReminderNotification($user->email, $user->id, $user->ascription->name, $course->id, $course->name,
                                                 $user->full_name, $course->credits, $course->modules()->count(), $user->numCompletedModulesOfCourse($course->id));
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
                                    $this->sendMonthReminderNotification($user->email, $user->id, $user->ascription->name, $course->id, $course->name,
                                     $user->full_name, $course->credits, $course->modules()->count(), $user->numCompletedModulesOfCourse($course->id));
                                }
                            }
                        }else{ // User has call notification from course
                            // echo "Usuario está en lista de llamada<br>";
                        }

                    }
                }
            }
        }else{
            return "No está activado el envío de notificaciones";
        }
        $time_end = $this->microtime_float();
        $time = $time_end - $time_start;
        return "Script terminado en {$time} segundos ";
        return Carbon::now();
    }

    public function sendMonthReminderNotification($email, $user_id, $ascription_name, $course_id, $course_name, $user_name, $credits, $numModules, $numCompletedModules){
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 2]);
        $route = route('ascription.login', $ascription_name)."?notification=".$token;
        Mail::to($email)->send(new MonthReminder($route, $course_name, $user_name, $credits, $numModules, $numCompletedModules));
        return true;
    }

    public function sendWeekReminderNotification($mobilePhone, $user_id, $ascription_name, $course_id){ // This function sends a sms
        $token = \Uuid::generate()->string;
        Notification::create(['code' => $token, 'user_id' => $user_id, 'course_id' => $course_id, 'type' => 3]);
        return;
        $url = route('ascription.login', $ascription_name)."?notification=".$token;
        if(strpos($mobilePhone, '+52') !== false ){ // Found
            $mobilePhone = "+52".$mobilePhone;
        }
        $mobilePhone = str_replace(' ', '', $mobilePhone);
        $sms = AWS::createClient('sns');
        $sms->publish([
                'Message' => 'Doctor, le echamos de menos en Academia-mc, ¿desea continuar con su curso? '.$url,
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

}
