<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = ['name','description','date_start','date_end','featured_image','featured','weight','category_id','difficulty','length'];

    public function likes(){

    	return $this->hasMany('App\Course_featured');
    }

    public function tags(){

    	return $this->hasMany('App\Course_tag');
    }

    public function enrrollments(){

    	return $this->hasMany('App\Enrrollment');
    }

    public function resources(){

    	return $this->hasMany('App\Resource');
    }

    public function category(){

    	return $this->belongsTo('App\Course');
    }

    public function getLengthAmmountAttribute(){
        $ammount = $this->length;
        if($ammount % 1440 == 0){
            return ($ammount/1440).' days';
        } else if ($ammount % 60 == 0){
            return ($ammount/60).' hours';
        } else{
            return $ammount.' minutes';
        }
    }


}
