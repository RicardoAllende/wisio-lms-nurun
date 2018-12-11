<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Controllers\Response;

class UsersController extends Controller
{
    public $singularName = 'user';
    public $pluralName = 'users';
    public $eloquentModel = User::class;
    public $secondId = 'email';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Response::showResults(buildQuery($this->eloquentModel, $request->input(), $this->pluralName));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        dd($request->input());
        // dd(User::first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->filled('users')){ // Massive import
            $users = $request->users;
            $duplicates = array();
            $numDuplicates = 0;
            $inserts = array();
            $numInserts = 0;
            foreach($users as $user){
                $email = $user['email'];
                $password = $user['password'];
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                // $enctype = (isset($user['enctype'])) ? $user['enctype'] : 'DEFAULT';
                if(User::whereEmail($email)->count() > 0){
                    $numDuplicates++;
                    array_push($duplicates, ['status' => 'error','message' => "Email < {$email} > ya existe"]);
                }else{
                    $numInserts++;
                    User::create(compact('email', 'password', 'firstname', 'lastname'));
                    array_push($inserts, ['status' => 'ok','message' => "Usuario < $email > creado correctamente"]);
                }
            }
            $response = [
                'num_inserts' => $numInserts,
                'num_duplicates' => $numDuplicates,
                'inserts' => $inserts,
                'duplicates' => $duplicates
            ];
            return response()->json($responseMaker->showSeveralFields($response, 200), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(isset($this->secondId)){
            if(is_numeric($id)) {
                $result = $this->eloquentModel::find($id);
            }else{
                $result = $this->eloquentModel::where($this->secondId, $id)->first();
            }
        } else {
            $result = $this->eloquentModel::find($id);    
        }
        return Response::showElement($this->singularName, $result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
