<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'mailing', 
        'last_content_update', 
        'max_month_reminders', 
        'max_week_reminders', 
        'invitation_sent', 
        'max_sms_reminders',
        'professional_license_service'
    ];
    public static function getRequiredAttributes() { return []; }
}