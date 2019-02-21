<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'id',
        'evaluation_id',
        'name',
        'content',
        'type',
        'is_true'
    ];
    public function options(){
    	return $this->hasMany('App\Option');
    }

    public static function getConditions() { return [ 'unique' => [], 'required' => ['evaluation_id', 'content'] ]; }
    public function correct(){
        return $this->options()->where('score', 1)->first();
    }

    public function evaluation(){
    	return $this->belongsTo('App\Evaluation');
    }

    public function hasOptions(){
        if ($this->options()->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function scoreOfQuestion($option_given){
        $option = Option::find($option_given);
        if($option == null) { return 0;}
        $options = $this->options;
        if($options->contains($option_given)){
            return $option->score;
        }else{
            return 0;
        }
    }

}