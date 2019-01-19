<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Notification;

class NotificationsController extends Controller
{
    public function listUsers(){
        return view('notifications.report.list-users');
    }

    public function listNotificationsForUser($email){

    }

    public function checkNotification($notification_id){ //call
        $notification = Notification::find($notification_id);
        if($notification != null){
            $user = $notification->user;
            if($user != null){
                $user->notifications()->where('course_id', $notification->course_id)->update(['viewed' => 1]);
            }
        }
        return back();
    }

    public function callList(){
        return view('notifications.report.call-list');
    }

    public function listUserNotifications($email){
        $user = User::whereEmail($email)->first();
        if($user == null){
            return back()->withErrors(['error' =>'Problemas al encontrar usuario']);
        }
        $notifications = $user->notifications;
        return view('notifications.report.user-notifications', compact('notifications', 'user'));
    }

}
