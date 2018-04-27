<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentTag extends Model
{
    protected $table = 'attachment_tag';
    protected $fillable = ['attachemnt_id', 'tag_id'];
}
