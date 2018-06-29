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
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $courses = Course::all();
        foreach(Course::cursor() as $course){
            $users = $course->incompleteUsers()->cursor();
            foreach($users as $user){
                $lastAdvance = $user->lastAdvanceInCourse($course->id);
                if($user->hasNotificationsFromCourse($course->id)){
                    $lastNotification = $user->lastNotificationFromCourse($course->id);
                    $timestampLastNotification = $lastNotification->created_at;
                    if($lastAdvance->gt($lastNotification->created_at)){ // Doctor had advance in the course after the notification, mailing is every month
                        if($lastNotification->viewed == 1){ // Doctor followed the link
                            if($lastNotification->type == 'month_reminder'){
                                $monthAgo = Carbon::now()->submonth();
                                if($timestampLastNotification->gt($monthAgo)){
                                    $this->sendMonthReminderNotification($user->email, $course);
                                }
                            }else if($lastNotification->type == 'week_reminder'){
                                $numWeekReminders = $user->numWeekReminderNotifications($course->id);
                                if($numWeekReminders < $this->maxWeekReminders){
                                    $weekAgo = Carbon::now()->subweek();
                                    if($timestampLastNotification->gt($weekAgo)){
                                        $this->sendWeekReminderNotification($user->mobile_phone, $course->id);
                                    }
                                }else{
                                    $this->addToListOfUsersToCall($user->id);
                                    if($user->hasAvailableAnotherCourse()){
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
                    $this->sendMonthReminderNotification($user->email, $course->id);
                }

            }
        }
    }

    public function sendNewCourseNotification($email, $course){

    }

    public function sendMonthReminderNotification($email, $course){
        $token = \Uuid::generate()->string;
        FakerMail::create(['email' => $email, 'type' => 'month_reminder', 'link' => route('login')."?notification=".$token]);
        return;
    }

    public function sendWeekReminderNotification($mobilePhone, $course){ // This function sends a sms
        $token = \Uuid::generate()->string;
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

    public function sendCourseCompletion($email, $token){

    }

    public function sendRecommendation(){
        $token = \Uuid::generate()->string;
        FakerMail::create(['email' => $email, 'type' => 'recommendation', 'link' => route('login')."?notification=".$token]);
        return;
    }

    public function addToListOfUsersToCall($user_id){

    }

}
