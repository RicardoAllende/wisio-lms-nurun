<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use Illuminate\Support\Facades\Auth;
use App\State;
use App\User;
use App\Role;
use GuzzleHttp\Client;
use App\Setting;
use App\Jobs\ProfessionalLicenseValidation;
use App\Http\Controllers\Janrain;

class UserController extends Controller
{
    public $apiMessage = "";   
    public $notA1 = false;
    public $sepServicesAreDown = false;

    public function updateInformation(){
        $user = Auth::user();
        $ascription = $user->ascription;
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
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $mobile_phone = $request->mobile_phone;
        if($this->validarNumero($mobile_phone) == false){
            return back()->withInput()->with('error', "Número no validado");
        }
        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();
        $user->last_profile_update = $dateTime;
        $user->save();
        
        // if($user->hasDifferentAscriptions()){
        //     return redirect()->route('student.select.ascription')->with('msj', 'Su información ha sido actualizada');
        // }
        $ascription = $user->ascription;
        return redirect()->route('student.home', $ascription->slug)->with('msj', 'Su información ha sido actualizada');
    }

    public function selectAscription(){
        $user = Auth::user();
        $ascriptions = $user->allAscriptions;
        $ascription = $user->allAscriptions->first();
        return view('users_pages/courses/diplomado', compact('ascriptions', 'user', 'ascription'));
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
        $mobile_phone = $request->mobile_phone;
        if($this->validarNumero($mobile_phone) == false){
            return back()->withInput()->with('error', "Número no validado");
        }
        $is_validated = $request->is_validated;
        if(User::where('professional_license', $professional_license)->count() > 0 ){ // Cédula exists
            return back()->withInput()->with('error', "Cédula repetida, ya existe un usuario con esa cédula");
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
        $user->ascription_id = $ascription->id;
        if( ! $request->filled('refered_code')){
            if($ascription->code == null){
                $refered_code = "ACADEMIAMC";
            }else{
                $refered_code = $ascription->code;
            }
            $user->refered_code = $refered_code;
        }
        $user->save();
        // ProfessionalLicenseValidation::dispatch($request->firstname, $request->paterno, $request->materno, $professional_license, $user->id);
        $email = $user->email;
        $password = $request->password;
        if(isset($inJanrain)){ // Don't register in janrain
            // No special action
        }else{ // Register in janrain
            $janRain = new Janrain;
            $janRain->janrainRegister($email, $password);
        }
        if(Auth::attempt(compact('email', 'password'))){
            return redirect('/');
        }
        return redirect('/');
    }

    public function requestVerifyProfessionalLicense(Request $request){
        $professional_license = $request->professional_license;
        $name = $request->name;
        $mid_name = $request->mid_name;
        $last_name = $request->last_name;
        if($this->verifyProfessionalLicense($professional_license, $name, $mid_name, $last_name)){
            echo 'ok';
            return;
        }else{
            if($this->sepServicesAreDown){
                echo "not-verified";
                return;
            }
            echo 'error';
            return;

        }
    }

    public function verifyProfessionalLicense($license, $firstname, $middlename, $lastname){
        $this->sepServicesAreDown = false;
        try{
            $client = new Client();
            $setting = Setting::first();
            $serviceUrl = $setting->professional_license_service;
            if($serviceUrl == ''){
                $serviceUrl = "https://dev.academia.nurun.com.mx/cedula/cedula/";
            }
            $response = $client->request('POST', $serviceUrl, [
                'form_params' => [
                    'name' => $firstname,
                    'mid_name' => $middlename,
                    'last_name' => $lastname,
                    'cedula' => $license
                ]
            ]);
            $responseString = $response->getBody()->getContents();
            $jsonResponse = json_decode($responseString);
            if($jsonResponse == false){
                $this->sepServicesAreDown = true;
                return false;
            }
            $status = $jsonResponse->{'status'};
            $message = $jsonResponse->{'message'};
            $this->sepServicesAreDown = false;
            switch ($status) {
                case '500': // unavailable service
                    $this->sepServicesAreDown = true;
                    return false;
                    break;
                case '404': // No data found or not valid
                    return false;
                    break;
                case '200':
                    $professional_license = $jsonResponse->{'cedula'};
                    // $type = $jsonResponse->{"tipo de cedula"};
                    if($license == $professional_license){
                        // if($type != 'A1'){
                        //     $this->notA1 = true;
                        //     return false;
                        // }
                        return true;
                    }
                    break;
                default:
                    return false;
                    break;
            }
            return false;
        } catch (\Exception $ex) { // In this case, service returns a no valid response (not a json)
            $this->sepServicesAreDown = true;
            return false;
        } catch (\Throwable $ex) {
            $this->sepServicesAreDown = true;
            return false;
        }
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

    public function validarCedula($professional_license){
        $len = strlen($professional_license);
        // dd($len);
        if(!($len == 8 || $len == 7)){
            return false;
        }
        if($professional_license == '00000000'){
            return false;
        }
        if($professional_license == '0000000'){
            return false;
        }
        $last3 = substr($professional_license, -3);
        if($last3 == '000'){
            return false;
        }
        return true;
    }

    public function validarNumero($phone_number){
        $repetidos = collect(['01234', '12345', '23456', '34567', '45678', '56789',
                '00000', '11111', '22222', '33333', '44444', '55555', '66666', '77777',
                '88888', '99999'
            ]);
        if(strlen($phone_number) != 10){
            return false;
        }
        foreach ($repetidos as $repetido) {
            $pos = strpos($phone_number, $repetido);
            if ($pos === false) {
                // correct phone
            } else {
                return false;
            }
        }
        return true;
    }

}
