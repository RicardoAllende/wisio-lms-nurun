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
      $view = \View::make('users_pages.certificates.insomnio')->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->setPaper('A4','landscape');
      $pdf->loadHTML($view);
      return $pdf->stream('diploma.pdf');
    }

    public function downloadCertificate($ascription_slug, $course_slug){
      try {
        $course = Course::whereSlug($course_slug)->first();
        if($course == null){ return back()->with('error', 'Hubo un problema al elaborar su diploma'); }
        $user = Auth::user();
        $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
        $template = $course->certificate_template();
        $view = \View::make($template, compact('course', 'user', 'pivot'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A4','landscape');
        $pdf->loadHTML($view);
        return $pdf->stream('certificado.pdf');
      } catch (\Exception $ex) {
        return back('Hubo un problema con la creación de su certificado, por favor contacte con '.config('constants.support_email'));
      } catch (\Throwable $ex) {
        return back('Hubo un problema con la creación de su certificado, por favor contacte con '.config('constants.support_email'));
      }
    }

    public function downloadDiploma($ascription_slug, $course_slug){
      try {
        // return "Elaborando diploma del curso: {$course_slug}";
        $course = Course::whereSlug($course_slug)->first();
        if($course == null){ return back()->with('error', 'Hubo un problema al elaborar su diploma'); }
        $user = Auth::user();
        $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if($pivot == null){
          return back()->with('error', 'Hubo un problema obteniendo su avance en el curso, intente más tarde');
        }
        if($pivot->score_in_diplomado == ''){ // user hasn't finished diploma evaluation
          return back()->with('error', 'Aún no ha realizado la evaluación del diplomado');
        }
        $template = $course->diploma_template();
        $view = \View::make($template, compact('course', 'user', 'pivot'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A4','landscape');
        $pdf->loadHTML($view);
        return $pdf->stream('diploma.pdf');
      } catch (\Exception $ex) {
        return back('Hubo un problema con la creación de su diploma, por favor contacte con '.config('constants.support_email'));
      } catch (\Throwable $ex) {
        return back('Hubo un problema con la creación de su diploma, por favor contacte con '.config('constants.support_email'));
      }


    }
}
