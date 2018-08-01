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
            $notification->accessed = 1;
            $notification->save();
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
        if($settings == null){
            Setting::create([
                'mailing' => 0, 
                'max_month_reminders' => 4, 
                'max_week_reminders' => 2,
                'max_sms_reminders' => 2,
                'professional_license_service' => '127.0.0.1/cedula'
            ]);
        }
        return view('notifications.set-settings', compact('settings'));
    }

    public function updateSettings(Request $request){
        $settings = Setting::first();
        if($settings == null){
            Setting::create([
                'mailing' => $request->mailing, 
                'max_month_reminders' => $request->max_month_reminders, 
                'max_week_reminders' => $request->max_week_reminders,
                'max_sms_reminders' => $request->max_sms_reminders,
                'professional_license_service' => $request->professional_license_service
            ]);
        }
        $settings->mailing = $request->mailing;
        $settings->max_month_reminders = $request->max_month_reminders;
        $settings->max_week_reminders = $request->max_week_reminders;
        $settings->max_sms_reminders = $request->max_sms_reminders;
        $settings->professional_license_service = $request->professional_license_service;
        $settings->save();
        return redirect()->route('form.settings');
    }

}
