<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\CourseModule;
use App\Course;
use App\AttachmentModule;
use App\ModuleUser;
use App\Expert;
use App\Resource;

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
        // Create a module for a specific course
        if(isset($_GET['course_id'])){
            $course_id = $_GET['course_id'];
            $course = Course::find($course_id);
            if($course != null){
                return view('modules/form', compact('course'));
            }
        }
        $courses = Course::all();
        if(isset($_GET['forDiplomat'])){
            $id = $_GET['forDiplomat'];
            $diplomat = 1;
            $course = Course::find($id);
            if($course == null){
                return back()->withErrors([
                    'error' => "El curso no fue encontrado"
                ]);
            }
            return view('modules/form', compact('course', 'diplomat'));
        }
        // For create a course and relate to a expert
        if(isset($_GET['expert_id'])){
            $expert_id = $_GET['expert_id'];
            return view('modules/form', compact('expert_id', 'courses'));
        }
        return view('modules/form', compact('courses'));
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
            'course_id' => $request->course_id,
            'sort' => $request->sort
        ]);

        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentModule::create(['attachment_id' => $attach_id, 'module_id' => $module->id]);
        }

        if($request->filled('expert_id')){
            $expert_id = $request->expert_id;
            $expert = Expert::find($expert_id);
            if( $expert != null){
                $module->attachExpert($expert_id);
                return back();
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
            $resources = $module->resources;
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
        if ($module == null) { // Module doesn't exist
            return redirect()->route('modules.index');
        }
        $courses = Course::all();
        return view('modules/form', compact('module', 'courses'));
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
        $module->course_id = $request->course_id;
        $module->sort = $request->sort;
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
        return back();
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
        return redirect()->route('list.modules.for.course', $course_id);
    }

    public function dropImgAttachments($module){
        $images = $module->attachments->where('type', 'main_img');
        foreach($images as $image){
            $image->delete();
        }
    }

    public function listExperts($module_id){
        $module = Module::find($module_id);
        if($module == null){ return false; }
        $experts = Expert::all();
        return view('modules/list-experts', compact('experts', 'module'));
    }

    public function orderResources($module_id){
        $module = Module::find($module_id);
        $resources = $module->resources;
        // return $resources;
        return view('modules/order-resources', compact('module', 'resources'));
    }

}