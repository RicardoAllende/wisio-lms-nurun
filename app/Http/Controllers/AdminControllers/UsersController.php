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

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            if ($type == 'doctors') {
                $type = [config('constants.roles.doctor')];
            }
            $role = Role::where('name', $type)->pluck('id');
            $users = User::whereIn('role_id', $role)->get();
        }else{
            $users = User::all();
        }
        return view('Users/list', compact('users'));
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
            $cedula = $request->cedula;
            if(User::whereCedula($cedula)->count() > 0 ){ // Cédula exists
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
        return view('Users/form',compact('user', 'ascriptions'));
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
        $user->is_pharmacy = $request->is_pharmacy;
        $user->save();
        if($request->filled('ascription_id')){
            $ascription_id = $request->ascription_id;
            $user->attachAscription($ascription_id);
        }
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

    /**
     * Returns the response from the url
     */
    public function getResponse($query){
        $ch = curl_init();
        $url = "http://search.sep.gob.mx/solr/cedulasCore/select?&wt=json&q=".$query;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);
        echo $output;
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
            $user->enabled = 0;
            $user->save();
        }
        return back();
    }

}