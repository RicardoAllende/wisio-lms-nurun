<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);
        if($request->filled('token')){ // Login by token, LMS user
            $client = Client::whereToken($request->token)->first();
            if($client != null){
                $user = $client->user;
                $user->last_access = now();
                $user->save();
                Auth::login($user);
                return $this->initializeSession($user);
            }else{
                return $this->loginError();
            }
        }else{
            if( Auth::attempt($credentials) ){
                $user = Auth::user();
                $user->last_access = now();
                $user->save();
                if($user->enabled){
                    return $this->initializeSession($user);
                }
            }
            return Response::loginError();
            return $this->loginError();
        }
    }

    public function initializeSession($user){
        $responseMaker = new Response;
        $token = $user->createToken('Personal Access Token');
        // $sessionToken = (string) Str::uuid();
        // $response = $responseMaker->successLogin($token->accessToken, $user);
        return Response::successLogin($token->accessToken, $user);
        return response()->json($response, $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }

    public function loginError(){
        $responseMaker = new Response;
        $response = $responseMaker->loginError();
        return response()->json($response, $status = 401, $headers = [], $options = JSON_PRETTY_PRINT);
    }

    public function checkUserByToken(){
        if(Auth::check()){
            $user = Auth::user();
            if($user->enabled){
                $user->last_access = now();
                $user->save();
                return $this->initializeSession($user);
            }
        }
        return $this->loginError();  
    }
}
