<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AscriptionAttachment extends Model
{
    protected $table = 'ascription_attachment';
    protected $fillable = ['ascription_id'::class, 'attachment_id'];

    public function showModels() {
        return [
            Ascription::class,
            Category::class,
            Course::class,
            Diploma::class,
            Evaluation::class,
            Expert::class,
            Module::class,
            // notification::class,
            Option::class,
            Question::class,
            Reference::class,
            Resource::class,
            Specialty::class,
            State::class,
            Tag::class,
            User::class
        ];
    }
    public static function getConditions() { return [ 'unique' => [], 'required' => ['ascription_id', 'attachment_id'] ]; }
}
