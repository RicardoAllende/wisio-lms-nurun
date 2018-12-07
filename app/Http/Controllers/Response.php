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
    public static function showAll($dataName, $data, $code){
        $numElements = $data->count();
        $response = [
            "response" => self::makeResponseField($status = "ok", $message = "", $code ),
            "data" => [
                'num_rows' => $numElements,
                $dataName => $data
            ]
        ];
        return self::returnResponse($response, $code);
    }

    public static function showSeveralFields($data, $code){
        $response = [
            "response" => self::makeResponseField($status = "ok", $message = "", $code = 200 ),
            "data" => $data
        ];
        return self::returnResponse($response, 200);
        return $response;
    }

    public static function makeResponseField($status, $message, $code){
        return [
            "status" => $status,
                "message" => $message,
                "http_code" => $code,
                // "errors" => [
                //     "user_message" => "",
                //     "internal_message" => "",
                //     "code" => "",
                //     "message" => ""
                // ],
            
        ];
    }

    /**
     * @param boolean $exists defines if the user is stored in db and is active
     * @return json response
     */
    public static function verifyUserExists($exists){
        if($exists){
            $status = 'ok';
            $message = "User exists";
            $code = 200;
        }else{
            $status = 'error';
            $message = "User not found";
            $code = 404;
        }
        $response = [
            "response" =>  self::makeResponseField($status, $message, $code),
            "data" => []
        ];
        return self::returnResponse($response, 200);
    }

    public static function elementNotFound($dataname){
        $response = [
            "response" => self::makeResponseField($status = "error", $message = "{$dataname} not found", $code = 404 ),
            "response" => [
                "status" => "error",
                "message" => "{$dataname} not found",
                "http_code" => "404",
                "errors" => [
                    "user_message" => "",
                    "internal_message" => "",
                    "code" => "",
                    "message" => ""
                ],
            ],
            "data" => [
                'numRows' => 0
            ]
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

    public static function error($msg){
        $response = [
            "response" => self::makeResponseField($status = "error", $msg, $code = 409 ),
            "data" => []
        ];
        return self::returnResponse($response, 409);
        return $response;
    }

    public static function isEmpty($element){
        if($element == null){
            return true;
        }
        if ($element instanceof \Illuminate\Database\Eloquent\Collection) {
            return $element->isEmpty();
        }
        if(is_array($element)){
            if(count($element) == 0){
                return true;
            }
        }
        return false;
    }

    public static function countElements($data){
        if ($data instanceof \Illuminate\Database\Eloquent\Collection) {
            return $data->count();
        }
        if(is_array($data)){
            return count($data);
        }
        return false;
    }

    public static function isOne($element){
        if ($element instanceof \Illuminate\Database\Eloquent\Collection) {
            return false;
        }
        if(is_array($element)){
            return false;
        }
        return true;
    }

}
