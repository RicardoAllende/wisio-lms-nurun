<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Evaluation;
use App\Module;
use App\EvaluationUser;
use App\AttachmentEvaluation;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations = Evaluation::all();
        return view('evaluations/list', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (isset($_GET['module_id'])) {
            $module_id = $_GET['module_id'];
            $module = Module::find($module_id);
            if( $module != null){
                return view('evaluations/form', compact('module'));
            }
        }
        $modules = Module::all();
        return view('evaluations/form', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $evaluation = Evaluation::create($input);
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentEvaluation::create(['attachment_id' => $attach_id, 'evaluation_id' => $evaluation->id]);
        }
        return redirect()->route("evaluations.show", $evaluation->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluation = Evaluation::find($id);
        if($evaluation == null) { return redirect('evaluations.index'); }
        $course = $evaluation->module->course;
        $approved = EvaluationUser::where('evaluation_id', $id)->where('score', '>=', $course->minimum_score)->count();
        return view('evaluations/show',compact('evaluation', 'approved'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evaluation = Evaluation::find($id);
        return view('evaluations/form',compact('evaluation'));
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
        $evaluation = Evaluation::find($id);
        if($evaluation == null){ return redirect()->route('evaluations.index'); }
        $evaluation->name = $request->name;
        $evaluation->description = $request->description;
        $evaluation->maximum_attempts = $request->maximum_attempts;
        $evaluation->save();
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropImgAttachments($evaluation);
            AttachmentEvaluation::create(['attachment_id' => $attach_id, 'evaluation_id' => $evaluation->id]);
        }
        return redirect()->route("evaluations.show", $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evaluation = Evaluation::find($id);
        $evaluation->delete();
        return redirect()->route('evaluations.index');
    }

    public function dropImgAttachments($evaluation){
        $images = $evaluation->attachments->where('type', 'main_img');
        foreach($images as $image){
            $image->delete();
        }
    }

    public function emptyEvaluations(){
        $evaluations = Evaluation::all();
        return view('empty-evaluations', compact('evaluations'));
    }

}
