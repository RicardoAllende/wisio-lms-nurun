<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Recordatorio2 extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $route, $doctor_name, $credits, $course_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route, $doctor_name, $credits, $course_name)
    {
        $this->route = $route;
        $this->doctor_name = $doctor_name;
        $this->credits = $credits;
        $this->course_name = $course_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM'))
        ->view('email.recordatorio-2', 
            [
                'route' => $this->route,
                'doctor_name' => $this->doctor_name,
                'credits' => $this->credits,
                'course_name' => $this->course_name
            ]
        );
    }
}
