<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Course;
use App\User;
use App\Ascription;
use App\Notification;

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
            $users = $course->usersIncomplete()->cursor();
            foreach($users as $user){
                $user->lastAdvanceInCourse($course->id);
            }
        }
    }

    public function sendNewCourseNotification($email, $token){

    }

    public function sendMonthReminderNotification($email, $token){

    }

    public function sendWeekReminderNotification($email, $token){

    }

    public function sendCourseCompletion($email, $token){

    }

}
