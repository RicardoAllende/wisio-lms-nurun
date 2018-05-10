<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentModule extends Model
{
    protected $table = 'attachment_module';
    protected $fillable = ['attachment_id', 'module_id'];
}
