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
    protected $course;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route, $course)
    {
        $this->route = $route;
        $this->course = $course;
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
        ->view('email.not-approved', ['course' => $this->course, 'route' => $this->route]);
    }
}
