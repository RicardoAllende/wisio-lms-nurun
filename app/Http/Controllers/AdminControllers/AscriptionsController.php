<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ascription;
use App\AscriptionAttachment;

class AscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ascriptions = Ascription::all();
        if($ascriptions->count() < 1){
            return redirect()->route('ascriptions.create');
        }
        return view('ascriptions/list', ['ascriptions'=>$ascriptions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ascriptions/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'description', 'slug']);
        $ascription = Ascription::firstOrCreate($input);
        $ascription->save();
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AscriptionAttachment::create(['attachment_id' => $attach_id, 'ascription_id' => $ascription->id]);
        }
        return redirect()->route('ascriptions.show', $ascription->id); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            return view('ascriptions/show', ['ascription' => $ascription]);
            // return "Mostrando la adscripción número {$id}";
        }else{
            return redirect()->route('ascriptions.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            return view('ascriptions/form', compact('ascription'));
        }else{
            return redirect()->route('ascriptions.index');
        }
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
        $ascription = Ascription::find($id);
        if($ascription != null){
            if ($ascription->name != $request->input('name')) {
                $ascription->name = $request->input('name');
                $slug = $request->slug;
                $ascription->slug = $slug;
            }
            $ascription->description = $request->input('description');
            $ascription->save();
            if($request->filled('attachment')){
                $attach_id = $request->input('attachment');
                $this->dropImgAttachments($ascription);
                AscriptionAttachment::create(['attachment_id' => $attach_id, 'ascription_id' => $ascription->id]);
            }
            $ascription = Ascription::find($ascription->id);
            return view('ascriptions/show', compact('ascription'));
        }else{
            return redirect()->route('ascriptions.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            $ascription->delete();
        }
        return redirect()->route('ascriptions.index');
    }

    public function dropImgAttachments($ascription){
        $images = $ascription->attachments->where('type', 'main_img');
        foreach($images as $image){
            $image->delete();
        }
    }

}
