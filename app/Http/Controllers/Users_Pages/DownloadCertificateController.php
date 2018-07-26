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
        if($course == null){ return back()->with('error', 'Hubo un problema al elaborar su certificado'); }
        $user = Auth::user();
        $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if($user->hasCertificateForCourse($course->id)){
          $template = $course->certificate_template();
          $months = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
          $view = \View::make($template, compact('course', 'user', 'pivot', 'months'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->setPaper('A4','landscape');
          $pdf->loadHTML($view);
          return $pdf->stream('certificado.pdf');
        }else{
          return redirect()->route('certificates.list', $ascription_slug);
        }
      } catch (\Exception $ex) {
        return back()->with('error', 'Hubo un problema con la creación de su certificado, por favor contacte con '.config('constants.support_email'));
      } catch (\Throwable $ex) {
        return back()->with('error', 'Hubo un problema con la creación de su certificado, por favor contacte con '.config('constants.support_email'));
      }
    }

    public function downloadDiploma($ascription_slug, $course_slug){
      try {
        $course = Course::whereSlug($course_slug)->first();
        if($course == null){ return back()->with('error', 'Hubo un problema al elaborar su diploma'); }
        if( ! $course->has_diploma){
          return redirect()->route('certificates.list', $ascription_slug)->with('error', 'El curso no ofrece diploma');
        }
        $user = Auth::user();
        $enrollment = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if($enrollment == null){
          return back()->with('error', 'Hubo un problema obteniendo su avance en el curso, intente más tarde');
        }
        if($enrollment->score_in_diplomado == ''){ // user hasn't finished diploma evaluation
          return back()->with('error', 'Aún no ha realizado la evaluación del diplomado');
        }
        if($enrollment->score_in_diplomado >= $course->minimum_diploma_score){
          $template = $course->diploma_template();
          $months = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
          $view = \View::make($template, compact('course', 'user', 'pivot', 'months'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->setPaper('A4','landscape');
          $pdf->loadHTML($view);
          return $pdf->stream('diploma.pdf');
        }else{
          return redirect()->route('certificates.list', $ascription_slug)->with('error', 'No obtuvo una calificación aprobatoria en el curso');
        }
      } catch (\Exception $ex) {
        return back()->with('error', 'Hubo un problema con la creación de su diploma, por favor contacte con '.config('constants.support_email'));
      } catch (\Throwable $ex) {
        return back()->with('error', 'Hubo un problema con la creación de su diploma, por favor contacte con '.config('constants.support_email'));
      }


    }
}
