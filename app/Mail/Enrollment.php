<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Enrollment extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $url;
    protected $course_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $course_name)
    {
        $this->url = $url;
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
        ->view('email.course-enrollment', ['url' => $this->url, 'course_name' => $course_name]);
    }
}
