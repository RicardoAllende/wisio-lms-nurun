<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ascription;
use App\RecommendedCourse;
use App\AscriptionCourse;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'has_constancy'
    ];

    public function likes(){
        return RecommendedCourse::where('course_id', $this->id)->count();
    }

    public function recommended(){
        return $this->hasMany('App\RecommendedCourse');
    }

    public function specialties(){
        return $this->belongsToMany('App\Specialty');
    }

    public function hasModules(){
        if($this->modules->count() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function evaluations(){
        return $this->hasMany('App\Evaluation');
    }

    public function hasEvaluations(){
        if ($this->evaluations->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function belongsToAscription($id){
        $ascription = Ascription::find($id);
        if($ascription == null){ // The ascription doesn't exist
            return false;
        }
        $rows = AscriptionCourse::where('ascription_id', $id)->where('course_id', $this->id)->count();
        if($rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public function hasRelations(){
        if($this->ascriptions->count() > 0){
            return true;
        }
        if($this->modules->count() > 0){
            return true;
        }
        if($this->attachments->count() > 0){
            return true;
        }
        return false;
    }

    public function ascriptions(){
        return $this->belongsToMany('App\Ascription');
    }

    public function tags(){
    	return $this->belongsToMany('App\Tag');
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('status');
    }

    public function resources(){
    	return $this->hasMany('App\Resource');
    }

    public function categories(){
    	return $this->belongsToMany('App\Category');
    }

    public function modules(){
    	return $this->belongsToMany('App\Module');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return ''; }
        return "/".$img->url;
    }

    public function hasMainImg(){
        if($this->attachments->where('type', 'main_img')->count() > 0){ 
            return true;
        }else{
            return false;
        }
    }

    public function finalEvaluationsFromModules(){
        $modules = $this->modules;
        $result = collect();
        foreach($modules as $module){
            $result = $result->concat($module->evaluations->where('type', config('constants.evaluations.final')));
        }
        return $result;
    }

    public function diagnosticEvaluationsFromModules(){
        $modules = $this->modules;
        $result = collect();
        foreach($modules as $module){
            $result = $result->concat($module->evaluations->where('type', config('constants.evaluations.diagnostic')));
        }
        return $result;
    }

    public function calculateAvgFromModuleEvaluations($user_id){
        $evaluations = $this->finalEvaluationsFromModules()->pluck('id');
        return DB::table('evaluation_user')->select(DB::raw('max(score) as score'))->where('user_id', $user_id)->whereIn('evaluation_id', $evaluations)->groupBy('evaluation_id')->get()->avg('score');
    }
}
