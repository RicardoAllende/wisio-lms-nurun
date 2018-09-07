<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\Course;
use App\CourseUser;
use Illuminate\Support\Facades\Auth;
use App\Diploma;
use App\DiplomaUser;

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
          if($pivot->downloaded_at == null){
            $pivot->downloaded_at = now();
            $pivot->save();
          }
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

    public function downloadDiploma($ascription_slug, $diploma_slug){
      // try {
        $diploma = Diploma::whereSlug($diploma_slug)->first();
        if($diploma == null){ return back()->with('error', 'Hubo un problema al elaborar su diploma'); }
        $user = Auth::user();
        $pivot = DiplomaUser::where('user_id', $user->id)->where('diploma_id', $diploma->id)->first();
        if($pivot == null){
          return back()->with('error', 'Hubo un problema obteniendo su avance en el diploma, intente más tarde');
        }
        if($pivot->downloaded_at == null){
          $pivot->downloaded = true;
          $pivot->downloaded_at = now();
          $pivot->save();
        }
        if($pivot->score == '' || $pivot->status == false ){ // user hasn't finished diploma evaluation
          return back()->with('error', 'Aún no ha realizado la evaluación del diplomado');
        }
        if($pivot->score >= $diploma->minimum_score){
          $template = $diploma->diploma_template();
          $months = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
          $view = \View::make($template, compact('course', 'user', 'pivot', 'months'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->setPaper('A4','landscape');
          $pdf->loadHTML($view);
          return $pdf->stream('diploma.pdf');
        }else{
          return redirect()->route('certificates.list', $ascription_slug)->with('error', 'No obtuvo una calificación aprobatoria en el diploma');
        }
      // } catch (\Exception $ex) {
      //   return back()->with('error', 'Hubo un problema con la creación de su diploma, por favor contacte con '.config('constants.support_email'));
      // } catch (\Throwable $ex) {
      //   return back()->with('error', 'Hubo un problema con la creación de su diploma, por favor contacte con '.config('constants.support_email'));
      // }


    }
}
