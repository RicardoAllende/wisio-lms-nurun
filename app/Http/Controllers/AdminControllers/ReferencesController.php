<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reference;
use App\Module;

class ReferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($module)
    {
        $module = Module::find($module);
        if($module == null){
            return redirect()->route('modules.index');
        }
        $references = $module->references;
        return view('references/list', compact('references', 'module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($module_id)
    {
        $module = Module::find($module_id);
        if($module == null) { return redirect()->route('modules.index'); }
        return view('references/form', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($module_id, Request $request)
    {
        $module = Module::find($module_id);
        if($module == null) { return redirect()->route('modules.index'); }
        $content = $request->content;
        if($this->hasScripts($content)){
            return back()->withInput()->withErrors(['error' => 'Existe un script en el resumen']);
        }
        $content = $this->escapeString($content);
        $reference = Reference::create($request->input());
        $reference->content = $content;
        $reference->save();
        return redirect()->route('references.show', [$module->id, $reference->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($module_id, $id)
    {
        $reference = Reference::find($id);
        $module = Module::find($module_id);
        if($reference == null or $module == null ) { return redirect()->route('references.index', $module_id); }
        return view('references/show', compact('reference', 'module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($module_id, $reference_id)
    {
        $module = Module::find($module_id);
        if($module == null) { return redirect()->route('modules.index'); }
        $reference = Reference::find($reference_id);
        if($reference == null) { return redirect()->route('references.index', $module_id); }
        return view('references/form', compact('reference', 'module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($module_id, Request $request, $reference_id)
    {
        $reference = Reference::find($reference_id);
        if ($reference != null) { 
            $content = $request->content;
            if($this->hasScripts($content)){
                return back()->withInput()->withErrors(['error' => 'Existe un script en la referencia']);
            }
            $content = $this->escapeString($content);
            $reference->content = $content;
            $reference->save();
            return redirect()->route('references.show', [$module_id, $reference_id]);
        }else{ return redirect()->route('references.index', $module_id); }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($module_id, $reference_id)
    {
        $reference = Reference::find($reference_id);
        if ($reference != null) { $reference->delete(); }
        return redirect()->route('references.index', $module_id);
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

}
