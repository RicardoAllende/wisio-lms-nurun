<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Resource;
use App\Module;

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
        $incomplete = false;
        $correctFormat = false;
        $inexistentModule = false;
        $fileNotExists = false;
        if( ! $request->hasFile('file') ){
            $incomplete = true;
            $fileNotExists = true;
            // return "El archivo fue enviado";
        }
        if(!$fileNotExists){
            $fileName = $request->file('file')->getClientOriginalName();
            $fileFormat = $request->file('file')->getClientOriginalExtension();
            foreach (Resource::getSupportedExtensions() as $format) {
                if($fileFormat == $format){
                    $incomplete = true;
                    $correctFormat = true;
                }
            }
        }
        if( ! modelExists(Module::class, $request->module_id)){
            $inexistentModule = true;
        }
        if($incomplete){
            $errors = [];
            if($fileNotExists){
                array_push($errors, "File was not send");
            }
            if($inexistentModule){
                array_push($errors, "Module not found");
            }
            if(!$correctFormat){
                array_push($errors, "Format <{$fileFormat}> is not compatible");
            }

            return Response::error('Error creating resource', $errors);
        }
        
        $type = "video";
        $path = "resources";
        $filePath = request()->file('file')->store('public/'.$path);
        $filePath = str_replace('public', 'storage', $filePath);
        $name = request()->file('file')->getClientOriginalName();
        $mimeType = request()->file('file')->getMimeType();
        $type = substr($mimeType, 0, strpos($mimeType, '/'));
        
        $attachment = Attachment::create(['name'=>$name, 'type'=>$type, 'url' =>$filePath, 'mimetype' => $mimeType]);
        $attachment_id = $attachment->id;
        $module_id = $request->module_id;
        // $name = $request->name;
        // $module = Module::find($module_id);
        // $weight = $module->maxResourceWeight() + 1; // default weight
        // $attachment = Attachment::find($attachment_id);
        // $type = $attachment->type;
        // Resource::create(  );
        return Response::createdSuccessfully($dataName, insertElement(compact('attachment_id', 'module_id', 'type', 'name', 'weight'), $this->eloquentModel));
        return redirect()->route('modules.show', $module_id);


        insertElement(compact('attachment_id', 'module_id', 'type', 'name', 'weight'), $this->eloquentModel);
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
