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
            $user->save();
            $userId = $user->id;
            if($request->filled('ascription_id')){
                $ascription_id = $request->ascription_id;
                $user->attachAscription($ascription_id);
            }
            return redirect()->route('users.show',$userId);
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
            if($course != null){ // user and course exists
                $user->resetAdvanceInCourse($course_id);
            }
        }
        $pivot = CourseUser::where('user_id', $user_id)->where('course_id', $course_id)->first();
        $pivot->score = null;
        $pivot->save();
        return back();
    }

    public function showReportAllUsers(){
        $role = Role::where('name', config('constants.roles.doctor') )->pluck('id'); // doctors
        $users = User::whereIn('role_id', $role)->paginate(15);
        return view('users/report-all', compact('users'));
    }

    public function showReport($user_id){
        $user = User::find($user_id);
        if($user == null){ return redirect()->route('list.users.report'); }
        return view('users/report', compact('user'));
    }

    // public function listUsersToEnrolDiplomado(){
    //     $doctorRole = Role::where('name', config('constants.roles.doctor'))->pluck('id');
    //     $users = User::whereIn('role_id', $doctorRole)->get();
    //     return view('diplomado/list-users-to-enrol', compact('users'));
    // }

    // public function attachUserToDiplomado($ascription_id, $user_id){
    //     $ascription = Ascription::find($ascription_id);
    //     if($ascription == null){ return back()->withErrors(['Error' => 'Hubo un error en el identificador de la adscripción']); }
    //     if( ! $ascription->isDiplomado()){ return back()->withErrors(['Error' => 'Esta adscripción no es un diplomado, hubo un error de carga']); }
    //     $user = User::find($user_id);
    //     if($user == null){ return back()->withErrors(['Error' => 'Error al encontrar al usuario']); }
    //     if( ! $user->diplomados->contains($ascription_id)){
    //         $user->diplomados()->attach($ascription_id);
    //     }
    //     $courses = $ascription->courses;
    //     foreach($courses as $course){
    //         $course->enrolUser($user->id);
    //     }
    //     return back();
    // }

    // public function detachUserForDiplomado($ascription_id, $user_id){
    //     $user = User::find($user_id);
    //     if($user ==null) { return back()->withErrors(['Error' => 'Error al buscar usuario']); }
    //     $user->ascriptions()->detach($ascription_id);
    //     return back();
    // }

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
            if($user->hasAscriptions()){
                return $user->ascription()->name; 
            }
            return "";
        })
        // ->addColumn('diplomados', function ($user) {
        //     $names = '';
        //     if($user->hasDiplomados()){
        //         foreach($user->diplomados as $diploma){
        //             $names .= $diploma->name." ";
        //         }
        //     }
        //     return "";
        // })
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
            $doctor = User::find($user->user_id);
            if($doctor == null){ return 0; }
            return User::find($user->user_id)->numCompletedCoursesOfAscription($this->ascription_id);
            return $user->user_id;
        })
        ->addColumn('userLink', function ($user) {
            return '<a href="' . route('users.show', $user->user_id) .'">'.$user->user_id.'</button>'; 
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
        ->addColumn('enrollment', function ($user) {
            if($user->isEnrolledInDiplomado($this->diplomaId)){
                return '<a href="'.route('detach.user.to.diplomado', [$this->diplomaId, $user->id]).'" class="btn btn-danger btn-round" >Quitar del diplomado</a>';
            }else{
                return '<a href="'.route('attach.user.to.diplomado', [$this->diplomaId, $user->id]).'" class="btn btn-success btn-round" >Inscribir al diplomado</a>';
            }            
        })
        ->rawColumns(['status', 'enrollment', 'userLink'])
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
            $doctor = User::find($user->user_id);
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

}
