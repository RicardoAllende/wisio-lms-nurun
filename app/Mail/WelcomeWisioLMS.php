<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeWisioLMS extends Mailable
{
    use Queueable, SerializesModels;
    public $information;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($information)
    {
        $this->information = $this->information;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.welcome-wisio', [
            'adminName' => $this->information['adminName'],
            'route' => $this->information['route'],
            'users' => $this->information['users'],
            'adminEmail' => $this->information['adminEmail'],
            'password' => $this->information['password']
        ] )
        ->from(ENV('MAIL_FROM_', 'ricardo.allende@subitus.com'));
    }
}
