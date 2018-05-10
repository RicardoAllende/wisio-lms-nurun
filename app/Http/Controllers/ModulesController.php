<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\CourseModule;
use App\Course;
use App\AttachmentModule;
use App\ModuleUser;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();
        return view('modules/list', ['modules' => $modules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $module = Module::create([
            'name' => $request->name, 'description' => $request->description,
            'start_date' => $request->start_date, 'end_date' => $request->end_date
        ]);

        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentModule::create(['attachment_id' => $attach_id, 'module_id' => $module->id]);
        }

        if($request->filled('course_id')){
            $course_id = $request->course_id;
            if(Course::find($course_id) != null){
                CourseModule::create(['course_id' => $course_id, 'module_id' => $module->id]);
                return redirect()->route('courses.show', $course_id);
            }
        }

        return redirect()->route('modules.show', $module->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = Module::find($id);
        if($module != null){
            $timesPassed = ModuleUser::where('module_id', $id)->where('status', config('constants.status.passed'))->count();
            return view('modules/show', ['module'=>$module, 'timesPassed' => $timesPassed]);
        }else{
            return redirect()->route('modules.index');
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
        $module = Module::find($id);
        if ($module == null) {
            return redirect()->route('modules.index');
        }
        return view('modules/form', compact('module'));
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
        $module = Module::find($id);
        if($module == null){ return redirect()->route('modules.index'); }
        $module->name = $request->name;
        $module->description = $request->description;
        $module->start_date = $request->start_date;
        $module->end_date = $request->end_date;
        $module->save();
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropImgAttachments($module);
            AttachmentModule::create(['attachment_id' => $attach_id, 'module_id' => $module->id]);
        }
        $module = Module::find($id);
        return redirect()->route('modules.show', $module->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::find($id);
        if ($module != null) {
            $module->delete();
        }
        return redirect()->route('modules.index');
    }

    public function listForCourse($course_id){
        if(Course::find($course_id) == null){
            return back();
        }
        $modules = Module::all();
        return view('modules/list-for-course', compact('modules', 'course_id'));
    }

    public function createForCourse($course_id){
        $course = Course::find($course_id);
        if($course == null){
            return redirect()->route('modules.create');
        }
        return view('modules/form', compact('course'));
    }

    public function addToCourse(){
        
    }

    public function relateToCourse($module_id, $course_id){
        CourseModule::create(['module_id' => $module_id, 'course_id'=>$course_id]);
        return redirect()->route('list.modules.for.course', $course_id);
    }

    public function dissociateOfCourse($module_id, $course_id){
        $pivots = CourseModule::where('module_id', $module_id)->where('course_id', $course_id)->get();
        foreach($pivots as $pivot){
            $pivot->delete();
        }
        // return back();
        return redirect()->route('list.modules.for.course', $course_id);
    }

    public function dropImgAttachments($module){
        $images = $module->attachments->where('type', 'main_img');
        foreach($images as $image){
            $image->delete();
        }
    }

}
