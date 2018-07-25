<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPlatform extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $doctor_name, $route;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($doctor_name, $route)
    {
        $this->doctor_name = $doctor_name;
        $this->route = $route;
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
        ->view('email.new-platform', ['doctor_name' => $this->doctor_name, 'route' => $this->route]);
    }
}
