<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonthReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $route;
    protected $course_name, $user_name, $credits, $num_modules, $num_completed_modules;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route, $course_name, $user_name, $credits, $numModules, $numCompletedModules)
    {
        $this->route = $route;
        $this->course_name = $course_name;
        $this->user_name = $user_name;
        $this->credits = $credits;
        $this->num_modules = $numModules;
        $this->num_completed_modules = $numCompletedModules;
        $this->subject("Academia Sanofi");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM'))
        ->view('email.month-reminder', 
            [
                'route' => $this->route,
                'course_name' => $this->course_name,
                'user_name' => $this->user_name,
                'credits' => $this->credits,
                'num_modules' => $this->num_modules,
                'num_completed_modules' => $this->num_completed_modules
            ]
        );
    }
}
