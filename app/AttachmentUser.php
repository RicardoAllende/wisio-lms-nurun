<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentUser extends Model
{
    protected $table = 'attachment_user';
    protected $fillable = ['attachment_id', 'user_id'];
    public static function getRequiredAttributes() { return [ 'unique' => [], 'required' => ['attachment_id', 'user_id'] ]; }
}
