<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentCourse extends Model
{
    protected $table = 'attachment_course';
    protected $fillable = ['attachemnt_id', 'course_id'];
}
