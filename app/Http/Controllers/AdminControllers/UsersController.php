<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Attachment;
use App\Ascription;
use App\AscriptionUser;
use App\Role;
use App\Course;
use App\CourseUser;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use App\Notification;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('Users/list');
        // if (isset($_GET['type'])) {
        //     $type = $_GET['type'];
        //     if ($type == 'doctors') {
        //         $type = [config('constants.roles.doctor')];
        //     }
        //     $role = Role::where('name', $type)->pluck('id');
        //     $users = User::whereIn('role_id', $role)->paginate(15);
        // }else{
        //     $users = User::paginate(15);
        // }
        // return view('Users/list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ascriptions = Ascription::All();
        $roles = Role::all();
        return view('Users/form', compact('ascriptions', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        if($request->filled('public_register')){
            $email = $request->email;
            if(User::whereEmail($email)->count() > 0 ){ // Email exists
                return back()->withInput()->withErrors(
                    ['Error' => "Email repetido, ya existe un usuario con ese email"]
                );
            }
            $professional_license = $request->professional_license;
            if(User::where('professional_license', $professional_license)->count() > 0 ){ // Cédula exists
                return back()->withInput()->withErrors(
                    ['Error' => "Cédula repetida, ya existe un usuario con esa cédula"]
                );
            }
            $user = User::create($input);
            $user->lastname = $request->paterno.' '.$request->materno;
            $user->password = bcrypt($request->password);
            $user->role_id = Role::whereName(config('constants.roles.doctor'))->first()->id;
            $publicAscription = Ascription::whereIsMainAscription(1)->first();
            $user->ascriptions()->attach($publicAscription->id);
            $user->save();
            $email = $user->email;
            $password = $request->password;
            if(Auth::attempt(compact('email', 'password'))){
                $ascription = $user->ascription();
                return redirect()->route('student.home', $ascription->slug);
            }
        }
        try{
            $email = $request->email;
            if(User::whereEmail($email)->count() > 0 ){ // Email exists
                return back()->withInput()->withErrors(
                    ['Error' => "Email repetido, ya existe un usuario con ese email"]
                );
            }
            $user = User::create($input);
            return redirect()->route('users.show',$user->id);
        }catch(Exception $e){
            return back()->withInput()->withError('Existió un error al crear el usuario');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('Users/show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //$user = User::find($id);
        $ascriptions = Ascription::All();
        $roles = Role::All();
        return view('Users/form',compact('user', 'ascriptions', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->email = $request->email;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->professional_license = $request->professional_license;
        $user->role_id = $request->role_id;
        $user->save();
        // if($request->filled('ascription_id')){
        //     $ascription_id = $request->ascription_id;
        //     $user->attachAscription($ascription_id);
        // }
        return redirect()->route('users.show', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function listForAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null){
            return redirect()->route('users.index');
        }
        $users = $ascription->users;
        return view('Users/list', compact('users', 'ascription'));
    }

    public function resetDefaultPassword($user_id){
        $user = User::find($user_id);
        if($user != null){
            $user->password = config('constants.default_password'); // secret; to change this constant, go to config/constants.php
            $user->save();
        }
        return back();
    }

    public function disableUser($user_id){
        $user = User::find($user_id);
        if($user != null){
            $user->enabled = 0;
            $user->save();
        }
        return back();
    }

    public function enableUser($user_id){
        $user = User::find($user_id);
        if($user != null){
            $user->enabled = 1;
            $user->save();
        }
        return back();
    }

    public function resetCourseEvaluations($user_id, $course_id){
        $user = User::find($user_id);
        if ($user != null) {
            $course = Course::find($course_id);
            if($course != null){ // user and course exist
                $user->resetAdvanceInCourse($course_id);
            }
        }
        $pivot = CourseUser::where('user_id', $user_id)->where('course_id', $course_id)->first();
        $pivot->score = null;
        $pivot->save();
        return back();
    }

    public function showReportAllUsers(){
        // $role = Role::where('name', config('constants.roles.doctor') )->pluck('id'); // doctors
        // $users = User::whereIn('role_id', $role)->paginate(15);
        return view('users/report-all');
    }

    public function showReport($user_id){
        $user = User::find($user_id);
        if($user == null){ return redirect()->route('list.users.report'); }
        return view('users/report', compact('user'));
    }

    public function getUsersDataAdmin(){
        return \DataTables::of(User::query())
        ->addColumn('userLink', function ($user) {
            return '<a href="' . route('users.show', $user->id) .'">'.$user->id.'</button>'; 
        })
        ->addColumn('status', function ($user) {
            $status = ($user->enabled == 1) ? "Activo" : "Inactivo";
            return  $status; 
        })
        ->addColumn('full_name', function ($user) {
            return $user->firstname.' '.$user->lastname; 
        })
        ->addColumn('ascription_name', function ($user) {
            return "Nombre de la adscripción";
            return $user->ascription->name;
            return "";
        })
        ->addColumn('actions', function ($user) {
            if($user->enabled == 1){
                return '<a href="'.route('disable.user', $user->id).'" class="btn btn-danger btn-round" >Deshabilitar</a>';
            }else{
                return '<a href="'.route('enable.user', $user->id).'" class="btn btn-info btn-round" >Habilitar</a>';
            }            
        })
        ->rawColumns(['namelink', 'status', 'actions', 'userLink', 'ascription_name', 'full_name'])
        ->make(true);
    }

    public function getDataForNotifications(){
        // $users = User::take(10);
        return \DataTables::of(User::query())
        ->addColumn('userLink', function ($user) {
            // dd($user);
            $user = User::find($user->id);
            $hasNotification =  $user->hasNotifications();
            if($hasNotification){
                return '<a href="' . route('show.notifications.for.user', $user->email) .'">Ver notificaciones</button>'; 
            }
            return "Sin notificaciones";
        })
        ->addColumn('numMonthReminders', function ($user) {
            $user = User::find($user->id);
            return $user->numAllMonthReminderNotifications(); 
        })
        ->addColumn('numWeekReminders', function ($user) {
            $user = User::find($user->id);
            return  $user->numAllWeekReminderNotifications(); 
        })
        ->addColumn('firstNotification', function ($user) {
            $user = User::find($user->id);
            return $user->dateFirstNotification(); 
        })
        ->addColumn('lastNotification', function ($user) {
            $user = User::find($user->id);
            return $user->dateLastNotification(); 
        })
        ->addColumn('actions', function ($user) {
            $user = User::find($user->id);
            if($user->enabled == 1){
                return '<a href="'.route('disable.user', $user->id).'" class="btn btn-danger btn-round" >Deshabilitar</a>';
            }else{
                return '<a href="'.route('enable.user', $user->id).'" class="btn btn-info btn-round" >Habilitar</a>';
            }            
        })
        ->rawColumns(['userLink', 'actions', 'numMonthReminders', 'numWeedReminders', 'firstNotification', 'lastNotification'])
        ->make(true);
    }

    public function getUsersCallList(){
        $queryBuilder = Notification::whereType(4)->whereViewed(0);
        return \DataTables::of($queryBuilder)
        ->addColumn('phone_number', function ($notification) {
            return $notification->user->mobile_phone;
        })
        ->addColumn('full_name', function ($notification) {
            return $notification->user->full_name;
        })
        ->addColumn('professional_license', function ($notification) {
            return $notification->user->professional_license;
        })
        ->addColumn('course_name', function ($notification) {
            return $notification->course->name;
        })
        ->addColumn('check', function ($notification) {
            return '<a href="'.route('check.notification', $notification->id).'" class="btn btn-primary btn-round"><span class="glyphicon glyphicon-check"></span></a>'; 
        })
        ->addColumn('actions', function ($notification) {
            $user = $notification->user;
            if($user->enabled == 1){
                return '<a href="'.route('disable.user', $user->id).'" class="btn btn-danger btn-round" >Deshabilitar</a>';
            }else{
                return '<a href="'.route('enable.user', $user->id).'" class="btn btn-info btn-round" >Habilitar</a>';
            }    
        })
        ->addColumn('first_notification', function ($notification) {
            $user = $notification->user;
            return $user->dateFirstNotification();
            $user->dateFirstNotification($course_id);
        })
        ->rawColumns(['phone_number', 'full_name', 'check', 'professional_license', 'course_name', 'actions', 'first_notification'])
        ->make(true);
    }



    public $ascription_id;

    public function getDataForAscription($ascription_id){
        $this->ascription_id = $ascription_id;
        $ascription = Ascription::find($ascription_id);
        if($ascription == null){
            return false;
        }
        $users = $ascription->users();
        return \DataTables::of($users)
        ->addColumn('numCompletedCoursesOfAscription', function ($user) {
            $doctor = User::find($user->id);
            if($doctor == null){ return 0; }
            return $doctor->numCompletedCoursesOfAscription($this->ascription_id);
        })
        ->addColumn('userLink', function ($user) {
            return '<a href="' . route('users.show', $user->id) .'">'.$user->id.'</button>'; 
        })
        ->addColumn('status', function ($user) {
            $status = ($user->enabled == 1) ? "Activo" : "Inactivo";
            return  $status; 
        })
        ->addColumn('actions', function ($user) {
            if($user->enabled == 1){
                return '<a href="'.route('disable.user', $user->id).'" class="btn btn-danger btn-round" >Deshabilitar</a>';
            }else{
                return '<a href="'.route('enable.user', $user->id).'" class="btn btn-info btn-round" >Habilitar</a>';
            }
        })
        ->rawColumns(['namelink', 'status', 'actions', 'userLink', 'numCompletedCoursesOfAscription'])
        ->make(true);
    }

    public $diplomaId;

    public function getDataForAscriptionEnrollment($ascription_id){
        $this->diplomaId = $ascription_id;
        
        return \DataTables::of(User::query())
        ->addColumn('status', function ($user) {
            $status = ($user->enabled == 1) ? "Activo" : "Inactivo";
            return  $status; 
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    public $course_id;

    public function getDataForCourse($course_id){
        $this->course_id = $course_id;
        $course = Course::find($course_id);
        if($course == null){
            return false;
        }
        $users = $course->users();
        return \DataTables::of($users)
        ->addColumn('grade', function ($user){
            $doctor = User::find($user->id);
            if($doctor == null){ return 0; }
            return $doctor->scoreInCourse($this->course_id);
            return $user->scoreInCourse($this->course_id);
        })
        ->addColumn('status', function ($user) {
            $status = ($user->enabled == 1) ? "Activo" : "Inactivo";
            return  $status; 
        })
        ->rawColumns(['status', 'grade'])
        ->make(true);
    }

    public function getDataForDiplomado($course_id){
        $users = Course::find($course_id)->users()->whereNotNull('course_user.score_in_diplomado');
        return \DataTables::of($users)
        // ->addColumn('score', function ($element) {
        //     $user = User::find($element->user_id);
        //     $status = ($user->enabled == 1) ? "Activo" : "Inactivo";
        //     return  $status; 
        // })
        // ->rawColumns(['status', 'userLink'])
        ->make(true);
    }

}
