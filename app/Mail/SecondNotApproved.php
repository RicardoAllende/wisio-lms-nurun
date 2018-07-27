<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SecondNotApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $route;
    protected $course_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route, $course_name)
    {
        $this->route = $route;
        $this->course_name = $course_name;
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
        ->view('email.second-not-approved', ['course_name' => $this->course_name, 'route' => $this->route]);
    }
}
