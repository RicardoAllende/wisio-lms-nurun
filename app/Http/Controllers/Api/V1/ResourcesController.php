<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Resource;
use App\Module;
use App\Attachment;

class ResourcesController extends Controller
{
    public $singularName = 'resource';
    public $pluralName = 'resources';
    public $eloquentModel = Resource::class;
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
        if( ! modelExists(Module::class, $request->module_id)){
            $inexistentModule = true;
            $incomplete = true;
        }
        $attachment = createAttachment($request, false);
        if(gettype($attachment) == 'array'){ // if attachment is an array, it was an error
            return Response::error('Error creating resource', $attachment);
        }
        $module_id = $request->module_id;
        $type = $attachment->type;
        $name = $attachment->name;
        $attachment_id = $attachment->id;
        $module_id = $request->module_id;
        $input = compact('attachment_id', 'module_id', 'type', 'name');
        return Response::createdSuccessfully('Resource', insertElement($input, $this->eloquentModel));
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
        //
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
