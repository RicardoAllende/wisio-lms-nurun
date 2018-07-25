<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Reboot extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $route;
    protected $user_name;
    protected $course_name;
    protected $courses;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route, $user_name, $course_name, $courses)
    {
        $this->route = $route;
        $this->user_name = $user_name;
        $this->course_name = $course_name;
        $this->courses = $courses;
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
        ->view('mail.not-approved', 
            [
                'route' => $this->route, 
                'doctor_name' =>  $this->user_name, 
                'course_name' => $course_name
            ]
        );
    }
}
