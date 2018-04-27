<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentQuestion extends Model
{
    protected $table = 'attachment_question';
    protected $fillable = ['attachemnt_id', 'question_id'];
}
