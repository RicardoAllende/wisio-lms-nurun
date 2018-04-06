<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = ['name','description','featured_image'];

    public function courses()
    {
    	return $this->hasMany('App\Course');
    }

}
