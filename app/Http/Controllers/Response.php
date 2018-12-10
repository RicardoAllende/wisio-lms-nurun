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
        if(gettype($data) == 'boolean'){
            $code = 404;
            $response = [
                'response' => self::makeResponseField($status = 'error', $message = "Page not found", $code),
                'data' => []
            ];
        }else{
            $code = 200;
            $response = [
                "response" => self::makeResponseField($status = "ok", $message = "", $code ),
                "data" => $data
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

    public static function deletedSuccesfully($dataName){
        $response = [
            "response" => self::makeResponseField($status = "ok", $message = "Element deleted successfully", $code = 204 ),
            "data" => [
            ]
        ];
        return self::returnResponse($response, 204);
        return $response;
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

    public static function createdSuccessfully($dataName, $data){
        $response = [
            "response" => self::makeResponseField($status = "ok", $message = "Element created successfully", $code = 200 ),
            "data" => [
                $dataName => $data
            ]
        ];
        return self::returnResponse($response, 200);
        return $response;
    }

    public static function showElement($dataName,  $data){
        if(self::isEmpty($data)){
            return self::elementNotFound($dataName);
        }else{
            return self::returnResponse([
                'response' => self::makeResponseField('error', "{$dataName} not found", 200),
                'data' => [ $dataName => $data ]
            ], 200);
        }
    }

    public static function error($msg){
        $response = [
            "response" => self::makeResponseField($status = "error", $msg, $code = 409 ),
            "data" => []
        ];
        return self::returnResponse($response, 409);
        return $response;
    }

    public static function isEmpty($element){
        $type = gettype($element);
        switch ($type) {
            case 'string':
                if($element == '')
                return true;
                break;
            case 'array':
                if( count($element) == 0 )
                return true;
                break;
            case 'string':
                if($element == '')
                return true;
                break;
            case 'boolean':
                if(! $element)
                return false;
                break;
            case 'NULL':
                return true;
                break;
        }
        return false;
    }

}
