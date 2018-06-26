<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use Illuminate\Support\Facades\Auth;
use App\State;
use App\User;
use App\Role;

class UserController extends Controller
{

    public $tokenUrl = "https://dev.cedula.nurun.com.mx/api/v1/token?";
    public $client_id = "client_id=3";
    public $client_secret = "client_secret=Wpa2BbV4tNY69V5BOuWJALJxbvc2uLc9N7jd5Cqz";
    public $licenseService = "http://dev.cedula.nurun.com.mx/api/v1/license-number/";
    public $apiMessage = "";
    public $sepServicesAreDown = false;

    public function updateInformation(){
        $user = Auth::user();
        $ascription = $user->ascription();
        return view('Users/update', compact('user', 'ascription'));
    }

    public function update(Request $request){
        $user = Auth::user();
        $user->gender = $request->gender;
        $user->state_id = $request->state_id;
        $user->specialty_id = $request->specialty_id;
        $user->consultation_type = $request->consultation_type;
        $user->mobile_phone = $request->mobile_phone;
        $user->zip = $request->zip;
        $user->city = $request->city;
        $user->address = $request->address;
        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_profile_update = $dateTime;
        $user->save();
        if(session()->has('ascription_slug')){
            $slug = session('ascription_slug');
            if(Ascription::whereSlug($slug)->first() != null){
                return redirect()->route('student.home', $slug)->with('msj', 'Su información ha sido actualizada');
            }
        }
        if($user->hasDifferentAscriptions()){
            return redirect()->route('student.select.ascription')->with('msj', 'Su información ha sido actualizada');
        }
        $ascription = $user->ascription();
        return redirect()->route('student.home', $ascription->slug)->with('msj', 'Su información ha sido actualizada');
    }

    public function selectAscription(){
        $user = Auth::user();
        $ascriptions = $user->allAscriptions;
        $ascription = $user->allAscriptions->first();
        return view('users_pages/courses/diplomado', compact('ascriptions', 'user', 'ascription'));
    }

    public function setTemporalAscription($ascription_slug){
        session(['ascription_slug' => $ascription_slug]);
        return true;
    }

    public function getAllStates(){
        return State::all();
    }

    public function store(Request $request){
        $input = $request->input();
        $email = $request->email;
        if(User::whereEmail($email)->count() > 0 ){ // Email exists
            return back()->withInput()->with('error', "Email repetido, ya existe un usuario con email ".$email);
        }
        $professional_license = $request->professional_license;
        $is_validated = true;
        if(User::where('professional_license', $professional_license)->count() > 0 ){ // Cédula exists
            return back()->withInput()->with('error', "Cédula repetida, ya existe un usuario con esa cédula");
        }
        $response = $this->verifyProfessionalLicense($professional_license, $request->firstname, $request->paterno, $request->materno);
        if( ! $response ){
            if( $this->sepServicesAreDown ){
                $is_validated = false;
            }else{
                $this->sepServicesAreDown = false;
                return back()->withInput()->with('error', 'Cédula no validada');
            }
        }
        $user = User::create($input);
        $user->is_validated = $is_validated;
        $user->lastname = $request->paterno.' '.$request->materno;
        $user->password = bcrypt($request->password);
        $user->role_id = Role::whereName(config('constants.roles.doctor'))->first()->id;
        $ascription = null;
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_access = $dateTime;
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_profile_update = $dateTime;
        if($request->filled('seccion')){
            $ascription = Ascription::whereSlug($request->seccion)->first();
        }
        if($ascription == null){
            $ascription = Ascription::first();  // Academia Sanofi
        }
        $user->ascriptions()->attach($ascription->id);
        $user->save();
        $email = $user->email;
        $password = $request->password;
        if(Auth::attempt(compact('email', 'password'))){
            return redirect('/');
        }
    }

    public function verifyProfessionalLicense($license, $name, $middlename, $lastname){
        $accessToken = $this->getAccessToken();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->licenseService.$license,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$accessToken,
                "Cache-Control: no-cache",
                "Postman-Token: d7af23f7-6966-46bb-b105-d1955d3b2d9b"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        }
        $jsonResponse = json_decode($response);
        if(isset($jsonResponse->{'results'})){
            $numResults = $jsonResponse->{'results'};
            if($numResults == '1'){
                $license = $jsonResponse->{'licenses'};
                $license = $license[0];
                $licenseName = $license->{'name'};
                $licenseMiddleName = $license->{'middle_name'};
                $licenseLastName = $license->{'last_name'};
                $license_type = $license->{'license_type'};
                if(mb_strtoupper($name) != mb_strtoupper($licenseName)){
                    $this->apiMessage = "El nombre no coincide";
                    return false;
                }
                if(mb_strtoupper($middlename) != mb_strtoupper($licenseMiddleName)){
                    $this->apiMessage = "El nombre no coincide con el registrado en la cédula profesional";
                    return false;
                }
                if( mb_strtoupper($lastname) != mb_strtoupper($licenseLastName) ){
                    $this->apiMessage = "Su apellido materno no coincide con el registrado en la cédula profesional";
                    return false;
                }
                if(mb_strtoupper($license_type) != 'C1'){
                    // $this->apiMessage = "Su cédula no es del tipo ";
                    return false;
                }
                return true;

            }else{
                return false;
            }
        }

        if(isset($jsonResponse->{'message'})){
            $message = $jsonResponse->{'message'};
            if($message == 'Unauthenticated.'){

            }
            $this->sepServicesAreDown = true;
        }
        return false;
    }

    public function getAccessToken(){
        $tokenUrl = $this->tokenUrl.$this->client_id."&".$this->client_secret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, '1.1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $result = json_decode($output);
        if(isset($result->{'access_token'})){
            return $token = $result->{'access_token'};
        }
        return "-";
    }

}
