<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Response
{

    public static function noAuthorizedResponse(){
        $response = [
            "response" => self::makeResponseField($status = "error", $message = "forbidden", $code = 403 ),
            "data" => [

            ]
        ];
        return self::returnResponse($response, 403);
    }

    public static function noLoginResponse(){
        $response = [
            "response" => self::makeResponseField($status = "error", $message = "unauthorized", $code = 401 ),
            "data" => [

            ]
        ];
        return self::returnResponse($response, 403);
    }

    public static function defaultResponse($status, $message, $code, $data){
        return self::returnResponse([
            "response" => self::makeResponseField($status, $message, $code),
            "data" => $data
        ], $code);
    }

    public static function returnResponse($response, $code){
        return response()->json($response, $status = $code, $headers = [], $options = JSON_PRETTY_PRINT);
    }

    public static function successAction(){
        $response = [
            "response" => self::makeResponseField($status = "ok", $message = "", $code = 200 ),
            "data" => []
        ];
        return self::returnResponse($response, 200);
    }

    public static function successLogin($token, $user){
        $data = [
            "access_token" => $token,
            "firstname" => $user->firstname,
            "lastname" => $user->lastname
            // "role" => $user->role->type,
            // "lms_token" => $user->lmsToken()
        ];
        $response = [
            "response" => self::makeResponseField($status = "ok", $message = "", $code = 200 ),
            "data" => $data
        ];
        return self::returnResponse($response, 200);
    }

    public static function loginError(){
        $response = [
            "response" => self::makeResponseField($status = "error", $message = "incorrect credentials", $code = 404 ),
            "data" => []
        ];
        return self::returnResponse($response, 404);
        return $response;
    }

    /**
     * @param string $dataname
     * @param object, collect or empty $data
     * @param int $code Http code
     */
    public static function showResults($data){
        if(gettype($data) == 'array'){
            $code = 200;
            $response = [
                "response" => self::makeResponseField($status = "ok", $message = "", $code ),
                "data" => $data
            ];
        }else{
            $code = 404;
            $response = [
                'response' => self::makeResponseField($status = 'error', $message = "Page {$data} not found", $code),
                'data' => []
            ];
        }
        return self::returnResponse($response, $code);
    }

    public static function makeResponseField($status, $message, $code){
        return [
            "status" => $status,
            "message" => $message,
            "http_code" => $code,            
        ];
    }

    public static function elementNotFound($dataname){
        $response = [
            "response" => self::makeResponseField($status = "error", $message = "{$dataname} not found", $code = 404 ),
            "data" => []
        ];
        return self::returnResponse($response, 404);
        return $response;
    }

    public static function delete($status){
        if($status){
            return self::returnResponse(["response" => self::makeResponseField($status = "ok", $message = "Element deleted successfully", $code = 200)], 200);
        }else{
            return self::returnResponse(["response" => self::makeResponseField($status = "error", $message = "Element not found", $code = 404) ], 404);
        }
    }

    public static function updatedSuccessfully($dataName, $data){
        $response = [
            "response" => self::makeResponseField($status = "ok", $message = $dataName." updated successfully", $code = 201 ),
            "data" => [
                $dataName => $data
            ]
        ];
        return self::returnResponse($response, 201);
        return $response;
    }

    public static function updated($data){
        if($data['status']){
            return self::returnResponse([
                "response" => self::makeResponseField($status = "ok", "Updated successfully", $code = 200),
                'data' => $data['data']
            ], 200);
        }else{
            return self::returnResponse([
                'response' => self::makeResponseField('error', 'Error on update', 406),
                'errors' => $data['errors']
            ], 406);
        }
    }

    public static function createdSuccessfully($dataName, $data){
        // dd($data);
        if($data['status']){
            $code = 200;
            $response = [
                "response" => self::makeResponseField($status = "ok", $message = "Element created successfully", $code ),
                "data" => [
                    $dataName => $data
                ]
            ];
        }else{
            $code = 406;
            $response = [
                "response" => self::makeResponseField($status = "error", $message = "Not acceptable", $code ),
                "data" => [
                    $dataName => $data
                ]
            ];
        }
        return self::returnResponse($response, $code);
    }

    public static function showElement($dataName,  $data){
        if(empty($data)){
            return self::elementNotFound($dataName);
        }else{
            return self::returnResponse([
                'response' => self::makeResponseField('ok', "", 200),
                'data' => [ $dataName => $data ]
            ], 200);
        }
    }

    public static function error($msg, $errors){
        $response = [
            "response" => self::makeResponseField($status = "error", $msg, $code = 409 ),
            "data" => [],
            'errors' => $errors
        ];
        return self::returnResponse($response, 409);
        return $response;
    }

}
