<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CertificateTemplate;

class CertificateTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = CertificateTemplate::all();
        return view('certificate_templates/list', compact('templates'));
        // return "Certificate templates";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('certificate_templates/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CertificateTemplate::create($request->input());
        return redirect()->route('templates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $template = CertificateTemplate::find($id);
        if($template == null){ return redirect('templates.index'); }
        return view('certificate_templates/show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = CertificateTemplate::find($id);
        if($template == null){ return redirect('templates.index'); }
        return view('certificate_templates/form', compact('template'));
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
        $template = CertificateTemplate::find($id);
        if($template == null){ return redirect('templates.index')->withErrors(['E1' =>'Error al encontrar la plantilla']); }
        $template->name = $request->name;
        $template->attachment_id = $request->attachment_id;
        $template->save();
        return redirect()->route('templates.show', $template->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = CertificateTemplate::find($id);
        if($template == null){ return redirect('templates.index')->withErrors(['E1' => 'Error al encontrar la plantilla']); }
    }
}
