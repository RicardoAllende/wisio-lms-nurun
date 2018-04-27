<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard/dashboard');
    }

    public function minor()
    {
        return view('home/minor');
    }
}
