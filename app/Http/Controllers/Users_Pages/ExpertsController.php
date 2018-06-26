<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Expert;
use App\AttachmentExpert;
use App\Module;
use App\Specialty;
use App\Ascription;

class ExpertsController extends Controller
{
    public function index($ascription_slug)
    {
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        if($ascription == null){
            return redirect('/');
        }
        $name = "";
        $specialty = "";
        $expertIds = $ascription->expertIds();
        if (isset($_GET['name'])) { // Filter by name or category
            $name = $_GET['name'];
            $specialty = $_GET['specialty'];
            if($specialty != ''){
                $specialty = Specialty::find($specialty);
                if($specialty != null){
                    $experts = $specialty->experts()->where('name', 'like', '%'.$name.'%')->whereIn('experts.id', $expertIds)->get();
                }else{
                    $experts = Expert::where('name', 'like', '%'.$name.'%')->whereIn('id', $expertIds)->get();
                }
            }else{
                $specialty = '';
                $experts = Expert::where('name', 'like', '%'.$name.'%')->whereIn('id', $expertIds)->get();
            }
        }else{
            $experts = Expert::find($expertIds);
        }
        return view('users_pages/experts.list', compact('experts', 'name', 'specialty', 'ascription'));
    }

  public function listModules($ascription_slug, $expert_slug){
      $expert = Expert::where('slug', $expert_slug)->first();
      if($expert == null){ return redirect()->route('experts.index'); }
      $modules = Module::all();
      $ascription = Ascription::whereSlug($ascription_slug)->first();
      return view('experts/list-modules', compact('expert', 'modules', 'ascription'));
  }

  public function show($ascription_slug, $expert_slug)
  {
      $expert = Expert::where('slug', $expert_slug)->first();
      $ascription = Ascription::whereSlug($ascription_slug)->first();
      return view('users_pages/experts.show', compact('expert', 'ascription'));
  }

  public function getSpecialties(){
      return Specialty::all();
  }

}
