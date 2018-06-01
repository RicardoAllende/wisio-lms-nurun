<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Expert;
use App\AttachmentExpert;
use App\Module;
use App\Specialty;

class ExpertsController extends Controller
{
    public function index($adscription_slug)
    {
        $name = "";
        $specialty = "";
        if (isset($_GET['name'])) { // Filter by name or category
            $name = $_GET['name'];
            $specialty = $_GET['specialty'];
            if($specialty != ''){
                $specialty = Specialty::find($specialty);
                if($specialty != null){
                    $experts = $specialty->experts()->where('name', 'like', '%'.$name.'%')->get();
                }else{
                    $experts = Expert::where('name', 'like', '%'.$name.'%')->get();
                }
            }else{
                $specialty = '';
                $experts = Expert::where('name', 'like', '%'.$name.'%')->get();
            }
        }else{
            $experts = Expert::all();
        }
        return view('Users_Pages/experts.list', compact('experts', 'name', 'specialty'));
    }

  public function listModules($adscription_slug, $expert_slug){
      $expert = Expert::where('slug', $expert_slug)->first();
      if($expert == null){ return redirect()->route('experts.index'); }
      $modules = Module::all();
      return view('experts/list-modules', compact('expert', 'modules'));
  }

  public function show($adscription_slug, $expert_slug)
  {
      $expert = Expert::where('slug', $expert_slug)->first();
      return view('Users_Pages/experts.show', compact('expert'));
  }

  public function getSpecialties(){
      return Specialty::all();
  }

}
