<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Evaluation;
use App\Module;
use App\EvaluationUser;
use App\AttachmentEvaluation;
use App\Course;

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
        if($evaluation->isDiplomaEvaluation()){
            $course = $evaluation->course;
        }else{
            $course = $evaluation->module->course;
        }
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
        $evaluation->type = $request->type;
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
        // dd($evaluation);
        if($evaluation != null){
            $evaluation->delete();
        }
        return back();
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

    public function createFinalEvaluation($course_id){
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        return view('evaluations.form-final', compact('course'));
    }

    public function showDiplomaEvaluation($course_id, $evaluation_id){
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){
            return back()->withErrors(['error' => 'No se encontró la evaluación']);
        }
        return view('evaluations.show', compact('evaluation', 'course'));
    }

    public function editFinalEvaluation($course_id, $evaluation_id){
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){
            return back()->withErrors(['error' => 'No se encontró la evaluación']);
        }
        return view('evaluations.form-final', compact('course', 'evaluation'));
    }

    public function storeFinalEvaluation(Request $request, $course_id){
        $input = $request->input();
        // dd($input);
        $evaluation = Evaluation::create($input);
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentEvaluation::create(['attachment_id' => $attach_id, 'evaluation_id' => $evaluation->id]);
        }
        $evaluation->type = 's';
        $evaluation->save();
        // $course = Course::find($course_id);
        // if($course == null){
        //     return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        // }
        return redirect()->route("show.diploma.evaluation", [$course_id, $evaluation->id]);
    }

    public function updateFinalEvaluation(Request $request, $course_id, $id){
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
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        return redirect()->route("show.diploma.evaluation", [$course_id, $evaluation->id]);
        // return redirect()->route("evaluations.show", $id);
    }

}
