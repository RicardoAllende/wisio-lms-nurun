<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Recommendation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $route;
    protected $token;
    protected $courses;
    protected $users;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route, $courses, $user)
    {
        $this->route = $route;
        $this->courses = $courses;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $route = $this->route;
        return $this->from(env('MAIL_FROM'))
        ->view('email.recommendation', compact('route', 'courses'));
    }
}
