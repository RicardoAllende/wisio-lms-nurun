<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = [
        'name',
        'description',
        'date_start',
        'date_end',
        'featured_image',
        'featured',
        'weight',
        'category_id',
        'difficulty',
        'length'
    ];

    public function likes(){
    	return $this->hasMany('App\Course_featured');
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
