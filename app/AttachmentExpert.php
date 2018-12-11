<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentExpert extends Model
{
    protected $table = 'attachment_expert';
    protected $fillable = ['attachment_id', 'expert_id'];
    public static function getRequiredAttributes() { return []; }
}
