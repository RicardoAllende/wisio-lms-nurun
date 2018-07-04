<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ascription extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'is_pharmacy',
        'enabled'
    ];

    public function courses(){
        return $this->belongsToMany('App\Course');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
    // public function users(){
    //     return $this->belongsToMany('App\User')->withTimestamps();
    // }

    public function hasCourses(){
        if ($this->courses->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return config('constants.default_images.ascription'); }
        return "/".$img->url;
    }

    public function calendar(){
        return $this->attachments->where('type', config('constants.attachments.calendar'))->first();
    }

    public function calendarUrl(){
        $calendar = $this->calendar();
        if($calendar == null){ return config('constants.default_images.calendar'); } // default calendar
        return "/".$calendar->url;
    }

    public function hasMainImg(){
        if($this->attachments->where('type', config('constants.attachments.main_img'))->count() > 0){ 
            return true;
        }else{
            return false;
        }
    }

    public function hasCalendar(){
        if($this->attachments->where('type', config('constants.attachments.calendar'))->count() > 0){ 
            return true;
        }else{
            return false;
        }
    }

    public function isPharmacy(){
        if ($this->is_pharmacy == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isMainAscription(){
        if($this->is_main_ascription == 1){
            return true;
        }
        return false;
    }

    public function experts(){
        return Expert::find($this->expertIds());
    }

    public function specialties(){ // From experts
        $specialties = ExpertSpecialty::whereIn('expert_id', $this->expertIds())->select('specialty_id')->get();
        return Specialty::find($specialties);
    }

    public function expertIds(){
        $courses = $this->courses;
        $expert_ids = array();
        foreach($courses as $course){
            $modules = $course->modules;
            foreach($modules as $module){
                $experts = $module->experts;
                foreach($experts as $expert){
                    array_push($expert_ids, $expert->id);
                }
            }
        }
        return array_unique($expert_ids);
    }

    public function students(){
        $studentRole = Role::where('name', config('constants.roles.doctor'))->first();
        return $this->users->where('role_id', $studentRole->id);
    }

    public function hasRelations(){
        if($this->hasStudents()){
            return true;
        }
        if($this->hasCourses()){
            return true;
        }
        return false;
    }

    public function hasStudents(){
        if ($this->students()->count() > 0 ) {
            return true;
        }
        return false;
    }

    public function type(){
        if($this->isPharmacy()){
            return "Farmacia";
        }
        if($this->is_main_ascription == 1){
            return "Adscripción principal";
        }
        return $this->name;
    }

}
