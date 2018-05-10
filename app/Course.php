<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ascription;
use App\RecommendedCourse;
use App\AscriptionCourse;

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

    // public function likes(){
    // 	return $this->hasMany('App\Course_featured');
    // }

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

    public function likes(){
        RecommendedCourse::where('course_id', $this->id)->count();
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

    public function img_url(){
        $image = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($image == null){
            return ""; // Default image
        }
        return "/".$image->url;
    }
}
