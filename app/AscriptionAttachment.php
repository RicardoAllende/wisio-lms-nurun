<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AscriptionAttachment extends Model
{
    protected $table = 'ascription_attachment';
    protected $fillable = ['ascription_id', 'attachment_id'];
}
