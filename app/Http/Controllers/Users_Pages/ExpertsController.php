<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Expert;
use App\AttachmentExpert;
use App\Module;
use App\Specialty;

class ExpertsController extends Controller
{
  public function index()
  {
      $experts = Expert::all();
      return view('Users_Pages/experts.list', compact('experts'));
  }
}
