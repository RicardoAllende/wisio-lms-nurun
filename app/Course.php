<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ascription;

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

    public  function belongsToAscription($id){
        $ascription = Ascription::find($id);
        if($ascription == null){ // The ascription doesn't exist
            return false;
        }
        if($this->ascriptions->count() > 0 ){
            $ascriptionsThisCourseBelongsTo = $this->ascriptions->pluck('id');
            if($ascriptionsThisCourseBelongsTo->search($id) === false){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
        
    }

    public function ascriptions(){
        return $this->belongsToMany('App\Ascription');
    }

    public function tags(){
    	return $this->belongsToMany('App\Tag');
    }

    public function users(){
        return $this->belongsToMany('App\User');
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

}
