<?php

namespace App\Http\Controllers;
use App\Course;
use Illuminate\Support\Facades\Auth;
use App\Ascription;
use App\Notification;
use GuzzleHttp\Client;
use App\User;

class Janrain
{

    /**
     * Return true if user is authenticated and user exists in db. Session is started
     * Return false if user has incorrect credentials
     * Return -1 if user is authenticated in janrain, but not in academia
     */
    public function janrainLogin($email, $password){
        // $authenticated = false;
        $okStatus = 'ok'; // Response from janrain
        // $errorStatus = 'error'; // Response from janrain
        $client_id = 'kgw275x6u3nakdjq3u2e3v2nudjvtmwm';
        $flow = 'hcp_standard';
        $flow_version = '20180820225704340441';
        $locale = 'es-CO';
        $redirect_uri = 'http://localhost';
        $response_type = 'token';
        $form = 'signInForm';
        $client = new Client();
        $authUrl = "https://sanofi-dev.us-dev.janraincapture.com/oauth/auth_native_traditional";
        $response = $client->request('POST', $authUrl, [
            'form_params' => [
                'client_id' => $client_id,
                'flow' => $flow,
                'flow_version' => $flow_version,
                'locale' => $locale,
                'redirect_uri' => $redirect_uri,
                'response_type' => $response_type,
                'form' => $form,
                'signInEmailAddress' => $email, //'Academia_Sanofi_Dev@yopmail.com',
                'currentPassword' => $password // 'Welcome123$'
            ]
        ]);
        $responseString = $response->getBody()->getContents();
        $jsonResponse = json_decode($responseString);
        if($jsonResponse == false){ // Service unavailable or down, using default db login
            // $user = User::whereEmail($email)->first();
            // if($user == null){
            //     if( password_verify( $password , $user->password ) ){ // user is registered 
            //         return true;
            //     }else{
            //         return false;
            //     }
            // }
            if(Auth::attempt(compact('email', 'password'))){
                return true;
            }else{
                return false;
            }
        }
        $status = $jsonResponse->{'stat'};
        if($status == $okStatus){
            // dd("Autenticado");
            $user = User::whereEmail($email)->first();
            // dd($user);
            if($user == null){ // user exists in JanRain, but not in academia
                return -1;
            }
            $user->password = bcrypt($password);
            $user->save();
            // dd(compact('email', 'password'));
            Auth::attempt(compact('email', 'password'));
            // dd(Auth::user());
            // $access_token = $jsonResponse->{'access_token'};
            return true; // user is registered in Academia and janrain, password is updated if it had changed
        }
        return false;
    }

    /**
     * return true if register is correct
     * return false if email is already in use or janrain throws an error
     * return -1 if user is authenticated in janrain, but not in academia
     */
    public function janrainRegister($email, $password){
        $authenticated = false;
        $okStatus = 'ok'; // Response from janrain
        // $errorStatus = 'error'; // Response from janrain
        $client_id = 'kgw275x6u3nakdjq3u2e3v2nudjvtmwm';
        $flow = 'hcp_standard';
        $flow_version = '20180820225704340441';
        $locale = 'es-CO';
        $redirect_uri = 'http://localhost';
        $response_type = 'token';
        $form = 'registrationForm';
        $client = new Client();
        $registerUrl = "https://sanofi-dev.us-dev.janraincapture.com/oauth/register_native_traditional";
        $response = $client->request('POST', $registerUrl, [
            'form_params' => [
                'client_id' => $client_id,
                'flow' => $flow,
                'flow_version' => $flow_version,
                'locale' => $locale,
                'redirect_uri' => $redirect_uri,
                'response_type' => $response_type,
                'form' => $form,
                'emailAddress' => $email, //'Academia_Sanofi_Dev@yopmail.com',
                'newPassword' => $password, // 'Welcome123$'
                'newPasswordConfirm' => $password,
                'displayName' => $email
            ]
        ]);
        $responseString = $response->getBody()->getContents();
        $jsonResponse = json_decode($responseString);
        if($jsonResponse == false){ // Service unavailable or down, using default db login
            return false;
        }
        $status = $jsonResponse->{'stat'};
        if($status == $okStatus){
            return true;
        }
        return false;
    }

    public function updateUser($email, $oldPassword, $newPassword){
        
    }

    public function name(){
        return "Nombre retornado desde janrain";
    }

    public function verifyEmailExists($email){ // return 212 code
        // $authenticated = false;
        // $okStatus = 'ok'; // Response from janrain
        $email = "r@g-cpm";
        $password = "something strange";
        $errorStatus = 'error'; // Response from janrain
        $client_id = 'kgw275x6u3nakdjq3u2e3v2nudjvtmwm';
        $flow = 'hcp_standard';
        $flow_version = '20180820225704340441';
        $locale = 'es-CO';
        $redirect_uri = 'http://localhost';
        $response_type = 'token';
        $form = 'signInForm';
        $client = new Client();
        $authUrl = "https://sanofi-dev.us-dev.janraincapture.com/oauth/auth_native_traditional";
        $response = $client->request('POST', $authUrl, [
            'form_params' => [
                'client_id' => $client_id,
                'flow' => $flow,
                'flow_version' => $flow_version,
                'locale' => $locale,
                'redirect_uri' => $redirect_uri,
                'response_type' => $response_type,
                'form' => $form,
                'signInEmailAddress' => $email, //'Academia_Sanofi_Dev@yopmail.com',
                'currentPassword' => $password // 'Welcome123$'
            ]
        ]);
        $responseString = $response->getBody()->getContents();
        $jsonResponse = json_decode($responseString);
        // dd($jsonResponse);               
        if($jsonResponse == false){ // Service unavailable or down, using default db login
            return false;
        }
        $status = $jsonResponse->{'stat'};
        if($status == $errorStatus){
            $code = $jsonResponse->{'code'};
            if($code == '212'){
                return true;
            }
        }
        return false;
    }

}
