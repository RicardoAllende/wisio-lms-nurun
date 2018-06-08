<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class DownloadCertificateController extends Controller
{
    public function downloadPdf(Request $request){

      $view = \View::make('users_pages.certificates.pdf2')->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->setPaper('A4','landscape');
      $pdf->loadHTML($view);
      return $pdf->stream('diploma.pdf');
    }
}
