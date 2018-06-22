<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\Course;
use App\CourseUser;
use Illuminate\Support\Facades\Auth;

class DownloadCertificateController extends Controller
{
    public function downloadPdf(Request $request){
      $view = \View::make('users_pages.certificates.pdf')->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->setPaper('A4','landscape');
      $pdf->loadHTML($view);
      return $pdf->stream('diploma.pdf');
    }

    public function downloadCertificate($course_slug){
      $course = Course::whereSlug($course_slug)->first();
      if($course == null){ return back()->with('error', 'Hubo un problema al elaborar su diploma'); }
      $user = Auth::user();
      $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
      //dd($pivot);
      $view = \View::make('users_pages.certificates.pdf', compact('course', 'user', 'pivot'))->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->setPaper('A4','landscape');
      $pdf->loadHTML($view);
      return $pdf->stream('diploma.pdf');
    }
}
