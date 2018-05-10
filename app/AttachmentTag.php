<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentTag extends Model
{
    protected $table = 'attachment_tag';
    protected $fillable = ['attachment_id', 'tag_id'];
}
