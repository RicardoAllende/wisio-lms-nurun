<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['name', 'type', 'url', 'description', 'mimetype'];

    public function getStoragePath(){
        return str_replace('storage', 'public', $this->url);
    }
}
