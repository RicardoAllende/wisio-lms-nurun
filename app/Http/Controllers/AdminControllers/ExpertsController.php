<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expert;
use App\AttachmentExpert;
use App\Module;
use App\Specialty;

class ExpertsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experts = Expert::all();
        return view('experts/list', compact('experts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('experts/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'summary']);
        $name = $request->name;
        $summary = $request->summary;
        if($this->hasScripts($summary)){
            return back()->withInput()->withErrors(['error' => 'Existe un script en el resumen']);
        }
        $summary = $this->escapeString($summary);
        $slug = str_slug($name);
        $expert = Expert::firstOrCreate(compact('name', 'summary', 'slug'));
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentExpert::create(['attachment_id' => $attach_id, 'expert_id' => $expert->id]);
        }
        return redirect()->route('experts.show', $expert->id); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expert = Expert::find($id);
        if($expert == null){ return redirect()->route('experts.index'); }
        return view('experts/show', compact('expert'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expert = Expert::find($id);
        if($expert == null){ return redirect()->route('experts.index'); }
        return view('experts/form', compact('expert'));
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
        $input = $request->only(['name', 'summary']);
        $expert = Expert::find($id);
        if($expert == null){
            return redirect()->route('experts.index');
        }
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropPreviousProfileImg($expert);
            AttachmentExpert::create(['attachment_id' => $attach_id, 'expert_id' => $expert->id]);
        }
        $expert->name = $request->name;
        $summary = $request->summary;
        if($this->hasScripts($summary)){
            return back()->withInput()->withErrors(['error' => 'Existe un script en el resumen']);
        }
        $summary = $this->escapeString($summary);
        $expert->summary = $summary;
        $expert->slug = str_slug($request->name);
        $expert->update();
        return redirect()->route('experts.show', $expert->id); 
    }

    private function dropPreviousProfileImg($expert){
        $images = $expert->attachments->where('type', config('constants.attachments.main_img'));
        foreach ($images as $image) {
            $image->delete();
        }
    }

    private function hasScripts($string){
        if(strpos($string, 'script') === false){
            return false;
        }else{
            return true;
        }
    }

    public function escapeString($string){
        return $this->dropPTag($string);
    }

    public function dropPTag($string){
        $string = str_replace("<p>", "", $string);
        if(substr_count($string, "</p>") > 1){
            $string = str_replace("</p>", "<br>", $string);
        }else{
            $string = str_replace("</p>", "", $string);
        }
        return $string;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expert = Expert::find($id);
        if($expert != null){
            $expert->delete();
        }
        return redirect()->route('experts.index');
    }

    public function listSpecialties($expert_id){
        $expert = Expert::find($expert_id);
        if($expert == null){ return redirect()->route('experts.index'); }
        $specialties = Specialty::all();
        return view('experts/list-specialties', compact('expert', 'specialties'));
    }
    
    public function listModules($expert_id){
        $expert = Expert::find($expert_id);
        if($expert == null){ return redirect()->route('experts.index'); }
        $modules = Module::all();
        return view('experts/list-modules', compact('expert', 'modules'));
    }

    public function attachModule($expert_id, $module_id){
        $expert = Expert::find($expert_id);
        if($expert != null){ 
            $expert->attachModule($module_id);
        }
        return back();
    }

    public function detachModule($expert_id, $module_id){
        $expert = Expert::find($expert_id);
        if($expert != null){
            $expert->detachModule($module_id);
        }
        return back();
    }

    public function attachSpecialty($expert_id, $specialty_id){
        $expert = Expert::find($expert_id);
        if($expert != null){ 
            if(Specialty::find($specialty_id) != null){
                $expert->attachSpecialty($specialty_id);
            }
        }
        return back();
    }

    public function detachSpecialty($expert_id, $specialty_id){
        $expert = Expert::find($expert_id);
        if($expert != null){
            $expert->detachSpecialty($specialty_id);
        }
        return back();
    }

    public function searchByName($search){
        return Expert::where('name', 'like', '%'.$search.'%')->with(['specialties', 'attachments'])->get()->toJson();
    }

}
