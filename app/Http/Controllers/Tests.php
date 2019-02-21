<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Recordatorio;

class Tests extends Controller
{
    public $emailTest = "ricardo.allende.p@gmail.com";
    public function sendEmail($email = null){
        if($email == null){
            $email = $this->emailTest;
        }
        Mail::to($email)->send(new Recordatorio('https://google.com.mx'));
    }
}
