<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname', 
        'email', 
        'password',
        'birthday',
        'gender',
        'mobile_phone',
        'postal_code',
        'city',
        'state',
        'address',
        'cedula',
        'consultation_type',
        'lastaccess',
        'enable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function courses(){
        return $this->belongsToMany('App\Course')->withPivot('id', 'status');
    }

    public function modules(){
        return $this->belongsToMany('App\Module')->withPivot('status');
    }

    public function progressInModule($module_id){
        if (Module::find($module_id) != null) {
            $pivot = ModuleUser::where('user_id', $this->id)->where('module_id', $module_id)->first();
            if($pivot == null){
                return false;
            }
            return $pivot->status;
        }else{
            return false;
        }
    }

    public function dissociateAllAscriptions(){
        $relations = AscriptionUser::where('user_id', $this->id)->get();
        foreach($relations as $relation){
            $relation->delete();
        }
    }

    public function enrollToAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null) { return false; }
        AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $this->id]);
    }

    public function belongsToAscription($ascription_id){
        $rows = AscriptionUser::where('ascription_id', $ascription_id)->where('user_id', $this->id)->count();
        if($rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public function stateInCourse($course_id){
        if (Course::find($course_id) != null) {
            $pivot = CourseUser::where('user_id', $this->id)->where('course_id', $course_id)->first();
            if($pivot == null){
                return false;
            }
            return $pivot->status;
        }else{
            return false;
        }
    }

    public function dissociateFromAllAscriptions(){
        $relations = AscriptionUser::where('user_id', $this->id);
        foreach($relations as $relation){
            try{

            }catch(\Illuminate\Database\QueryException $e){
                
            }
            $relation->delete();
        }
    }

    public function evaluations(){
        return $this->belongsToMany('App\Evaluation')->withPivot('status');
    }

    public function custom_fields()
    {
        return $this->belongsToMany('App\CustomField');
    }

    public function ascriptions()
    {
        return $this->belongsToMany('App\Ascription');
    }

    public function hasAscriptions(){
        if ($this->ascriptions->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ascription(){
        if($this->hasAscriptions()){
            return $this->ascriptions->first();
        }else{
            return null;
        }
    }

    public function attachments()
    {
        return $this->belongsToMany('App\Attachment');
    }

    /**
     * Return answers for the questions the user has answered
     */

    public function answers(){
        return $this->belongsToMany('App\Question');
    }


    public function hasRole($role){
        if($this->role->where('name', $role)->first()){
            return true;
        }
        return false;
    }

    public function hasAscription(){
        if ($this->ascriptions->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function role(){
        return $this->belongsTo("App\Role");
    }

    // public function authorizeRoles($roles){
    //     if ($this->hasAnyRole($roles)) {
    //         return true;
    //     }
    //     return redirect()->route('permission.denied');
    // }

    // public function hasAnyRole($roles){
    //     if(is_array($roles)){
    //         foreach ($roles as $role) {
    //             if ($this->hasRole($role)) {
    //                 return true;
    //             }
    //         }
    //     }else{
    //         if($this->hasRole($roles)){
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // public function hasRole($role){
    //     if($this->roles()->where('name', $role)->first()){
    //         return true;
    //     }
    //     return false;
    // }

    

    public function isStudent(){
        return $this->hasRole('student');
    }

    public function isAdmin(){
        return $this->hasRole('admin');
    }

    public function specialties(){
        return $this->belongsToMany('App\Specialty');
    }
}
