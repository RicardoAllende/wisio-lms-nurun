<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function listUsers(){
        return view('notifications.report.list-users');
    }

    public function listNotificationsForUser($email){

    }

    public function checkNotification($notification_id){
        $notification = Notification::find($notification_id);
        if($notification != null){
            $notification->viewed = 1;
            $notification->save();
        }
        return back();
    }

    public function callList(){
        return view('notifications.report.call-list');
    }
}
