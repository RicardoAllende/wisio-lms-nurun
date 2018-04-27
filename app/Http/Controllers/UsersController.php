<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Attachment;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
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
        $user = User::create($input);
        $user->password = bcrypt($user->password);
        $user->save();
        $userId = $user->id;
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
        $user->firstname = $request->firstname;
        $user->username = $request->username;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->birth_day = $request->birth_day;
        $user->gender = $request->gender;
        $user->type = $request->type;
        $user->enable = $request->enable;
        // $path = $request->photo;
        $user->save();

        // $this->uploadImageUser($user->id,$path);

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
        $imagePath = request()->file('file')->store('users');
        $name = request()->file('file')->getClientOriginalName();
        $attachment = Attachment::create(['name'=>$name, 'type'=>'image', 'url' =>$imagePath]);
        $attachment = $attachment->id;
        echo $attachment;
    }

    

    public function uploadImageUser($userId,$path){
        //Storage::makeDirectory($courseId);
        //$arrPath = explode('/', $path);
        $newPath = 'users/'.$userId."/".substr($path, strrpos($path, "/") + 1);
        Storage::move($path,"public/".$newPath);
        Storage::delete($path);
        $user= User::find($userId);
        $user->photo= 'storage/'.$newPath;
        $user->save();
        return redirect('/users');
    }

    public function downloadCSV(){
        $data = User::all()->makeVisible('password')->toArray();
		return Excel::create('users', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download("csv");
    }

    public function uploadCSV(Request $request){
        $userCount = User::count();
        $imagePath = request()->file('file')->store('public/csv/');
        $newPath = substr( $imagePath,0, -4);
        $newPath = $newPath.".csv";
        Storage::move($imagePath, $newPath);
        $file = $newPath;
        $newPath = "storage/csv/".substr($newPath, strrpos($newPath, "/") + 1);
        Excel::load($newPath, function($reader) {
            foreach ($reader->get() as $usuario) {
                $exits = false;
                $hasContent = true;
                if(User::where('email',$usuario->email)->count() > 0){
                    $exits = true;
                }
                if(User::where('username',$usuario->username)->count() > 0){
                    $exits = true;
                }
                if(User::where('id',$usuario->id)->count() > 0){
                    $exits = true;
                }

                $hasContent = ($usuario->email == '') ? false : $hasContent;
                $hasContent = ($usuario->username == '') ? false : $hasContent;
                if(strlen($usuario->password) != 60){ // The password is not encrypted
                    $pass = bcrypt($usuario->password);
                }else{
                    $pass = $usuario->password;
                }

                if((!$exits) && $hasContent ){
                    User::Create([
                        'email' => $usuario->email,
                        'id' => $usuario->id,
                        'username' => $usuario->username,
                        'password' => $pass,
                        'firstname' => $usuario->firstname,
                        'lastname' => $usuario->lastname,
                        'birth_day' => $usuario->brith_day,
                        'gender' => $usuario->gender,
                        'type' => $usuario->type,
                        'source' => $usuario->source,
                        'source_token' => $usuario->source_token,
                        'lastaccess' => $usuario->lastaccess,
                        'enable' => $usuario->enable,
                        'created_at' => $usuario->created_ad,
                        'updated_at' => $usuario->updated_at,
                        'photo' => $usuario->photo
                    ]);
                }
            }
        });
        Storage::delete($file);
        echo "Se agregaron ".(User::count() - $userCount)." registros exitosamente.";
    }

    public function updateProfile(Request $request)
    {
        $user->firstname = $request->firstname;
        $user->username = $request->username;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->birth_day = $request->birth_day;
        $user->gender = $request->gender;
        $user->type = $request->type;
        $user->enable = $request->enable;
        $user->save();
        return redirect()->route('user.profile.form');
    }
}