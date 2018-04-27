<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentExpert extends Model
{
    protected $table = 'attachment_expert';
    protected $fillable = ['attachemnt_id', 'expert_id'];
}
