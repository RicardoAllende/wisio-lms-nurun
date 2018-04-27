<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentEvaluation extends Model
{
    protected $table = 'attachment_evaluation';
    protected $fillable = ['attachemnt_id', 'evaluation_id'];
}
