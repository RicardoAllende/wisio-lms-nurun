<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentCourse extends Model
{
    protected $table = 'attachment_course';
    protected $fillable = ['attachment_id', 'course_id'];
    public static function getConditions() { return [ 'unique' => [], 'required' => ['attachment_id', 'course_id'] ]; }
}
