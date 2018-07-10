<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedCourse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $url;
    protected $courses;
    protected $ascription_slug;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $courses, $ascription_slug)
    {
        $this->url = $url;
        $this->courses = $courses;
        $this->ascription_slug = $ascription_slug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM'))
        ->view('view.name', ['url' => $this->url, 'courses' => $courses, 'ascription_slug' => $this->ascription_slug]);
    }
}
