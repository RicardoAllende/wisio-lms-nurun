<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CertificateTemplate;
use App\Course;
use App\User;
use App\CourseUser;

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

    public function list(){
        $templates = CertificateTemplate::all();
        return view('certificate_templates.list', compact('templates'));
    }

    public function showTemplate($template_id){
        try {
            // $course = Course::whereSlug($course_slug)->first();
            // if($course == null){ return back()->with('error', 'Hubo un problema al elaborar su certificado'); }
            // $user = Auth::user();
            // $pivot = CourseUser::where('user_id', $user->id)->where('course_id', $course->id)->first();
            // if($user->hasCertificateForCourse($course->id)){
                $template = CertificateTemplate::find($template_id);
                if($template != null){
                    $template = $template->view_name;
                    $pivot = CourseUser::first();
                    $user = User::first();
                    $course = Course::first();
                    $months = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
                    $view = \View::make($template, compact('course', 'user', 'pivot', 'months'))->render();
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->setPaper('A4','landscape');
                    $pdf->loadHTML($view);
                    return $pdf->stream('certificado.pdf');
                }
            // }else{
            //   return redirect()->route('certificates.list', $ascription_slug);
            // }
        } catch (\Exception $ex) {
            return back()->with('error', 'Hubo un problema con la creación de su certificado, por favor contacte con '.config('constants.support_email'));
        } catch (\Throwable $ex) {
            return back()->with('error', 'Hubo un problema con la creación de su certificado, por favor contacte con '.config('constants.support_email'));
        }
    }
}
