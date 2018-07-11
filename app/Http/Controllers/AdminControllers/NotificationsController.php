<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Notification;
use App\Setting;

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

    public function settings(){
        $settings = Setting::first();
        return view('notifications.set-settings', compact('settings'));
        // return $settings;
    }

    public function updateSettings(Request $request){
        // dd($request);
        $settings = Setting::first();
        $settings->mailing = $request->mailing;
        $settings->maxMonthReminders = $request->maxMonthReminders;
        $settings->maxWeekReminders = $request->maxWeekReminders;
        $settings->save();
        return redirect()->route('form.settings');
    }

}
