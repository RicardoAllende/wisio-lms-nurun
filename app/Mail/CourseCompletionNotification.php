<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseCompletionNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $route;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //Notification
        return $this->from(env('MAIL_FROM'))
        ->view('email.course-completion', ['route' => $this->route ]);
    }
}
