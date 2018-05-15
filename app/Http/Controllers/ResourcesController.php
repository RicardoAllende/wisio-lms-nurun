<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attachment;
use App\Resource;

/**
 * This
 */

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
    public function create()
    {
        return view('resources/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = Resource::find($id);
        $attachment = $resource->attachment;
        $mimetype = substr($attachment->mimetype, 0, strpos($attachment->mimetype, '/'));
        return view('resources/show', compact('resource', 'attachment', 'mimetype'));
        return $attachment;
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

}
