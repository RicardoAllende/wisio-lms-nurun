<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('Users/list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Users/form');
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

        $path = $input['photo'];
        $userId = User::create($input)->id;

        $this->uploadImageUser($userId,$path);

        return redirect('/users');
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
        return view('Users/form',compact('user'));
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
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->birth_day = $request->birth_day;
        $user->sex = $request->sex;
        $user->type = $request->type;
        $user->enable = $request->enable;
        $path = $request->photo;
        $user->save();

        $this->uploadImageUser($user->id,$path);

        return redirect('/users');
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
        return redirect('/users');
    }

    public function uploadImage(Request $request){
        $imagePath = request()->file('file')->store('temps');
        echo $imagePath;
        
    }

    

    public function uploadImageUser($userId,$path){
        //Storage::makeDirectory($courseId);
        $arrPath = explode('/', $path);
        $newPath = 'public/users/'.$arrPath[1];
        Storage::move($path,$newPath);

        $user= User::find($userId);
        $user->photo= 'storage/users/'.$arrPath[1];
        $user->save();

        return redirect('/users');
    }
}
