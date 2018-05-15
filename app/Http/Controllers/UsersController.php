<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
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

    public $elementsPerPage = 15;

    public function index(){
        $doctorRoles = Role::where('name', config('constants.roles.private_doctor'))
            ->orWhere('name', config('constants.roles.public_doctor'))
            ->orWhere('name', config('constants.roles.pharmacy_doctor'))->pluck('id');
        $users = User::whereIn('role_id', $doctorRoles)->paginate($this->elementsPerPage);
        return view('Users/list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ascriptions = Ascription::All();
        return view('Users/form', compact('ascriptions'));
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
        try{
            $user = User::create($input);
            $user->save();
            $userId = $user->id;
            if($request->filled('ascription_id')){
                $ascription_id = $request->ascription_id;
                if($user->hasAscriptions()){
                    $user->dissociateAllAscriptions();
                }
                AscriptionUser::create(['ascription_id' =>$ascription_id, 'user_id' => $user->id]);
            }
            return redirect()->route('users.show',$userId);
        }catch(Exception $e){
            return "Existió un error al ingresar usuario";
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
        $user->save();
        if($request->filled('ascription_id')){
            $ascription_id = $request->ascription_id;
            if($user->hasAscriptions()){
                $user->dissociateAllAscriptions();
            }
            AscriptionUser::create(['ascription_id' =>$ascription_id, 'user_id' => $user->id]);
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
        $users = User::paginate($this->elementsPerPage);
        $ascription = Ascription::find($ascription_id);
        if($ascription == null){
            return redirect()->route('users.index');
        }
        return view('Users/list-for-ascription', compact('users', 'ascription'));
    }

    public function searchUsersByEmail($email){
        $users = User::where('email', 'like', '%'.$email.'%')->paginate($this->elementsPerPage);
        return view('Users/list',compact('users'));
    }

    public function searchUsersByName($name){
        $users = User::where(DB::raw('concat(firstname," ",lastname)') , 'LIKE' , '%'.$name.'%')->paginate($this->elementsPerPage);
        return view('Users/list',compact('users'));
    }

    public function lisetForAscriptionSearchByEmail($ascription_id, $email){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null){
            return redirect()->route('users.index');
        }
        $users = User::where('email', 'like', '%'.$email.'%')->paginate($this->elementsPerPage);
        return view('Users/list-for-ascription',compact('users', 'ascription'));
    }

    public function lisetForAscriptionSearchByName($ascription_id, $name){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null){
            return redirect()->route('users.index');
        }
        $users = User::where(DB::raw('concat(firstname," ",lastname)') , 'LIKE' , '%'.$name.'%')->paginate($this->elementsPerPage);
        return view('Users/list-for-ascription',compact('users', 'ascription'));
    }

    public function enrollToAscription($user_id, $ascription_id){
        $ascription = Ascription::find($ascription_id);
        if ($ascription == null) {
            return redirect()->route('ascriptions.index');
        }
        $user = User::find($user_id);
        if ($user == null) {
            return redirect()->route('list.users.for.ascriptions', $ascription_id);
        }
        $relation = AscriptionUser::firstOrCreate(['ascription_id' => $ascription_id, 'user_id' => $user_id]);
        return back();
    }

    public function dissociateForAscription($user_id, $ascription_id){
        $ascription = Ascription::find($ascription_id);
        if ($ascription == null) {
            return redirect()->route('ascriptions.index');
        }
        $user = User::find($user_id);
        if ($user == null) {
            return redirect()->route('list.users.for.ascriptions', $ascription_id);
        }
        $relations = AscriptionUser::where('ascription_id', $ascription_id)->where('user_id', $user_id)->get();
        foreach($relations as $relation){
            $relation->delete();
        }
        return back();
    }

}