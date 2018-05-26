<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ascription extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'has_constancy',
        'is_pharmacy',
        'maximum_attemps',
        'minimum_score',
        'enabled'
    ];

    public function courses(){
        return $this->belongsToMany('App\Course');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

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
        if($calendar == null){ return 'http://mediaroom.sanofi.com/wp-content/uploads/2016/06/969312-471x500.jpg'; } // default calendar
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

}
