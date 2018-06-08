<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use Illuminate\Support\Facades\Auth;

class CertificatesController extends Controller
{
    public function list($ascription_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $user = Auth::user();
        $certificates = $user->availableCertificates();
        return view('users_pages/certificates/list', compact('ascription', 'user', 'certificates'));
        // dd($certificates);
        // return $ascription;
    }
}
