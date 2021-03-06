<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentCategory extends Model
{
    protected $table = 'attachment_category';
    protected $fillable = ['attachment_id', 'category_id'];
    public static function getConditions() { return [ 'unique' => [], 'required' => ['attachment_id', 'category_id'] ]; }
}
