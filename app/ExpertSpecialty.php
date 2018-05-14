<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpertSpecialty extends Model
{
    protected $table = 'expert_specialty';
    protected $fillable = ['expert_id', 'specialty_id'];
}
