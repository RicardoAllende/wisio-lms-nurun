<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'summary'
    ];

    protected $appends = ['img'];

    public function modules(){
    	return $this->belongsToMany('App\Module');
    }

    public function attachments(){
        return $this->belongsToMany('App\Attachment');
    }

    public function getMainImgUrl(){
        $img = $this->attachments->where('type', config('constants.attachments.main_img'))->first();
        if($img == null){ return config('constants.default_images.expert'); }
        return "/".$img->url;
    }

    public function hasModules(){
        if ($this->modules->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function specialties(){
        return $this->belongsToMany('App\Specialty');
    }

    public function hasSpecialties(){
        if ($this->specialties->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function hasMainImg(){
        if($this->attachments->where('type', 'main_img')->count() > 0){ 
            return true;
        }else{
            return false;
        }
    }

    public function belongsToModule($module_id){
        if ( $this->modules->contains($module_id) ) {
            return true;
        } else {
            return false;
        }
    }

    public function shortSummary(){
        return substr($this->summary, 0, 20);
    }

    public function attachModule($module_id){
        if(Module::find($module_id) == null ){ return false; }
        if( ! $this->modules->contains($module_id)){
            $this->modules()->attach($module_id);
        }
        return false;
    }

    public function detachModule($module_id){
        return $this->modules()->detach($module_id);
    }

    public function attachSpecialty($specialty_id){
        if(Specialty::find($specialty_id) == null ){ return false; }
        if( ! $this->specialties->contains($specialty_id)){
            $this->specialties()->attach($specialty_id);
        }
        return false;
    }

    public function detachSpecialty($specialty_id){
        return $this->specialties()->detach($specialty_id);
    }

    public function hasSpecialty($specialty_id){
        if ($this->specialties->contains($specialty_id)) {
            return true;
        }
        return false;
    }

    public function getImgAttribute(){
        return $this->getMainImgUrl();
    }

}
