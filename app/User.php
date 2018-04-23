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
        'birth_day',
        'gender',
        'type',
        'source',
        'source_token',
        'lastaccess',
        'enable',
        'photo',
        'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function enrrollments(){
    //     return $this->hasMany('App\Enrrollment');
    // }

    public function enrrollments(){
        return $this->belongsToMany('App\Course');
    }

    public function custom_fields()
    {
        return $this->belongsToMany('App\CustomField');
    }

    public function ascriptions()
    {
        return $this->belongsToMany('App\Ascription');
    }

    public function photo_user()
    {
        return $this->hasOne('App\Attachment');
    }

    public function attachment()
    {
        return $this->belongsTo('App\Attachment');
    }

    /**
     * Return answers for the questions the user has answered
     */

    public function questions(){
        return $this->belongsToMany('App\Question');
    }

    public function question_users(){
        return $this->hasMany('App\QuestionUser');
    }

    public function roles(){
        return $this->belongsToMany("App\Role");
    }

    public function authorizeRoles($roles){
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, "Acción no autorizada");
    }

    public function hasAnyRole($roles){
        if(is_array($roles)){
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        }else{
            if($this->hasRole($roles)){
                return true;
            }
        }
        return false;
    }
    
    public function hasRole($role){
        if($this->roles()->where('name', $role)->first()){
            return true;
        }
        return false;
    }

}
