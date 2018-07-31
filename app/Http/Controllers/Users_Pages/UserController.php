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

class UserController extends Controller
{

    public $tokenUrl = "https://dev.cedula.nurun.com.mx/api/v1/token?";
    public $client_id = "client_id=3";
    public $client_secret = "client_secret=Wpa2BbV4tNY69V5BOuWJALJxbvc2uLc9N7jd5Cqz";
    public $licenseService = "http://dev.cedula.nurun.com.mx/api/v1/license-number/";
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
        if($this->validarCedula($professional_license) == false ){
            return back()->withInput()->with('error', "Cédula no validada");
        }
        $mobile_phone = $request->mobile_phone;
        if($this->validarNumero($mobile_phone) == false){
            return back()->withInput()->with('error', "Número no validado");
        }
        $is_validated = true;
        if(User::where('professional_license', $professional_license)->count() > 0 ){ // Cédula exists
            return back()->withInput()->with('error', "Cédula repetida, ya existe un usuario con esa cédula");
        }
        $response = $this->verifySecondMethod($professional_license, $request->firstname, $request->paterno, $request->materno);
        if( ! $response ){
            if( $this->sepServicesAreDown ){
                $is_validated = false;
            }else{
                $this->sepServicesAreDown = false;
                $error = 'Cédula no validada';
                if($this->notA1){
                    $error = "Su cédula profesional no es de tipo A1";
                }
                return back()->withInput()->with('error', $error);
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
        $user->ascription_id = $ascription->id;
        // $user->ascriptions()->attach($ascription->id);
        $user->save();
        $email = $user->email;
        $password = $request->password;
        if(Auth::attempt(compact('email', 'password'))){
            return redirect('/');
        }
    }

    public function verifyProfessionalLicense($license, $name, $middlename, $lastname){
        try {
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
                    if(mb_strtoupper($license_type) != 'A1'){
                        $this->apiMessage = "Su cédula no es del tipo A1";
                        $this->notA1 = true;
                        return false;
                    }
                    return true;

                }else{
                    return false;
                }
            }
            return false;
        } catch (\Exception $ex) {
            $this->sepServicesAreDown = true;
            return false;
        } catch (\Throwable $ex) {
            $this->sepServicesAreDown = true;
            return false;
        }
        
    }

    public function verifySecondMethod($license, $firstname, $middlename, $lastname){
        try{
            $client = new Client();
            $response = $client->request('POST', 'http://httpbin.org/post', [
                'form_params' => [
                    'name' => 'abc',
                    'mid_name' => '',
                    'last_name' => '123',
                    'cedula' => ''
                ]
            ]);
            $responseString = $response->getBody()->getContents();
            $jsonResponse = json_decode($responseString);
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
                    $type = $jsonResponse->{"tipo de cedula"};
                    if($license == $professional_license){
                        if($type != 'A1'){
                            $this->notA1 = true;
                            return false;
                        }
                        return true;
                    }
                    break;
                default:
                    return false;
                    break;
            }
            return false;
        } catch (\Exception $ex) {
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
