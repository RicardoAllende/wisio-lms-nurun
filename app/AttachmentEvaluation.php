<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentEvaluation extends Model
{
    protected $table = 'attachment_evaluation';
    protected $fillable = ['attachment_id', 'evaluation_id'];
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['attachment_id', 'evaluation_id'] ]; }
}
