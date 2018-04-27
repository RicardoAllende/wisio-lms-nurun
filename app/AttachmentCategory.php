<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentCategory extends Model
{
    protected $table = 'attachment_category';
    protected $fillable = ['attachemnt_id', 'category_id'];
}
