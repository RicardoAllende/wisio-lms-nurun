<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentUser extends Model
{
    protected $table = 'attachment_user';
    protected $fillable = ['attachemnt_id', 'user_id'];
}
