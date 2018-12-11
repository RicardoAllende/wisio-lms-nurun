<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AscriptionAttachment extends Model
{
    protected $table = 'ascription_attachment';
    protected $fillable = ['ascription_id', 'attachment_id'];

    public function showModels() {
        return [
            new Ascription,
            new Category,
            new Course,
            new Diploma,
            new Evaluation,
            new Expert,
            new Module,
            // new notification,
            new Option,
            new Question,
            new Reference,
            new Resource,
            new Specialty,
            new State,
            new Tag,
            new User
        ];
    }
    public static function getRequiredAttributes() { return []; }
}
