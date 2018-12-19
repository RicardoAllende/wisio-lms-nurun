<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Notification;

class NotificationsController extends Controller
{
    public $singularName = 'notification';
    public $pluralName = 'notifications';
    public $eloquentModel = Notification::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Response::showResults(buildQuery($this->eloquentModel, $request->input(), $this->pluralName));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->filled($this->pluralName)){ // Massive import
            $elements = $request[$this->pluralName];
            $errors = array();
            $numErrors = 0;
            $inserts = array();
            $numInserts = 0;
            $results = [];
            foreach($elements as $element){
                $insertion = insertElement($element, $this->eloquentModel);
                if($insertion['status']){
                    array_push($inserts, $insertion);
                    $numInserts++;
                }else{
                    array_push($errors, $insertion);
                    $numErrors++;
                }
            }
            $code = ($numInserts > 0) ? 200 : 406;
            $message = ($numInserts > 0) ? 'ok' : 'error';
            $response = [
                'num_inserts' => $numInserts,
                'num_errors' => $numErrors,
                'inserts' => $inserts,
                'messages' => $errors
            ];
            return Response::defaultResponse($message, '', $code, $response);
        } else {
            return Response::createdSuccessfully($this->singularName, insertElement($request->input(), $this->eloquentModel));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = findModel($this->eloquentModel, $id);
        return Response::showElement($this->singularName, $result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return Response::updated(updateElement(findModel($this->eloquentModel, $id), $request->input()));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
      return Response::delete(deleteModel($this->eloquentModel, $id));
    }
}
