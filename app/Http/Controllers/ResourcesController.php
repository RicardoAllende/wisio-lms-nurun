<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attachment;
use App\Resource;
use App\Module;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return config('constants');
        return Attachment::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($module_id)
    {
        $module = Module::find($module_id);
        if($module != null){
            return view('resources/form', compact('module'));
        }
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($module_id, Request $request)
    {
        $attachment_id = $request->attachment_id;
        $module_id = $request->module_id;
        $name = $request->name;
        $module = Module::find($module_id);
        if( ! $module->hasResources()){
            $weight = 1;
        }else{
            $weight = $module->resources->count();
        }
        $attachment = Attachment::find($attachment_id);
        $type = $attachment->type;
        Resource::create( compact('attachment_id', 'module_id', 'type', 'name') );
        return redirect()->route('modules.show', $module_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($module_id, $id)
    {
        $module = Module::find($module_id);
        $resource = Resource::find($id);
        $attachment = $resource->attachment;
        $type = $attachment->type;
        return view('resources/show', compact('resource', 'attachment', 'type', 'module'));
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
    }

    public function uploadResource(Request $request){
        $name = request()->file('file')->getClientOriginalName();
        $type = request()->file('file')->getMimeType();
        $path = request()->file('file')->store('public/resources');
        $path = str_replace('public', 'storage', $path);
        $attach = Attachment::create(['name'=>$name , 'type'=> $type,'url'=>$path]);
        // return redirect()->action('ResourcesController@show', $attach->id);
        // return "El archivo se guardó en: ".$path;
        echo $attach->id;
    }

    public function orderResources($module_id){
        return Module::find($module_id)->resources;
    }

}
