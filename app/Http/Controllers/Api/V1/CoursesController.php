<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Course;
use App\User;
use App\CourseUser;

class CoursesController extends Controller
{
    public $singularName = 'course';
    public $pluralName = 'courses';
    public $eloquentModel = Course::class;
    public $secondId = 'slug';
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->filled($this->pluralName)){ // Massive import
            $elements = $request[$this->pluralName];
            $errors = array();
            $numErrors = 0;
            $inserts = array();
            $numInserts = 0;
            $results = [];
            foreach($elements as $element){
                $insertion = insertElement($element, $this->eloquentModel);
                if($insertion['status']){
                    array_push($inserts, $insertion);
                    $numInserts++;
                }else{
                    array_push($errors, $insertion);
                    $numErrors++;
                }
            }
            $code = ($numInserts > 0) ? 200 : 406;
            $message = ($numInserts > 0) ? 'ok' : 'error';
            $response = [
                'num_inserts' => $numInserts,
                'num_errors' => $numErrors,
                'inserts' => $inserts,
                'messages' => $errors
            ];
            return Response::defaultResponse($message, '', $code, $response);
        } else {
            return Response::createdSuccessfully($this->singularName, insertElement($request->input(), $this->eloquentModel));
        }
    }

    public function enrolUsers(Request $request){
        $numEnrolledUsers = 0;
        $enrolledUsers = [];
        $numErrors = 0;
        $errors = [];
        $numNotFound = 0;
        $notFoundUsers = [];
        $repeated = [];
        $numRepeated = 0;

        if($request->filled('course_id')){
            $course_id = $request->course_id;
            $course = findModel($this->eloquentModel, $course_id);
            // dd($course);
            if($course == null){
                return Response::error('Course not found', [
                    "Course < {$course_id} > not found"
                ]);
            }
        }else{
            return Response::error('Course not found', [
                "course_id is required"
            ]);
        }

        $usersEmpty = false;
        if($request->filled('users')){
            $users = $request->users;
            if(gettype($users) != 'array'){
                $usersEmpty = true;
            }
        }else{
            $usersEmpty = true;
        }
        if($usersEmpty){
            return Response::error('missing users parameter', [
                "users field is required, you need to send an array with users to enrol in the course"
            ]);
        }
        foreach ($users as $user) {
            $u = findModel(User::class, $user);
            if($u != null){
                $result = insertPivot(CourseUser::class, 'course_id', $course->id, 'user_id', $u->id);
                if($result === 2){
                    array_push($repeated, "User <{$u->email}> is already enrolled");
                    $numRepeated++;
                }elseif ($result == true) {
                    array_push($enrolledUsers, "User <{$u->email}> enrolled successfully");
                    $numEnrolledUsers++;
                }elseif ($result == false) {
                    array_push($errors, "Cannot enrol <{$u->email}>");
                    $numErrors++;
                }
            }else{
                $numNotFound++;
                array_push($notFoundUsers, "User <{$user}> doesn't exist");
            }
        }
        $data = [
            "num_enrollments" => $numEnrolledUsers,
            'enrolled_users' => $enrolledUsers,
            'repeated_users' => $repeated,
            'num_repeated_users' => $numRepeated,
            'num_not_found_users' => $numNotFound,
            'not_found_users' => $notFoundUsers
        ];
        $code = ($numEnrolledUsers > 0) ? 200 : 406;
        $message = ($numEnrolledUsers > 0) ? 'ok' : 'error';
        return Response::defaultResponse($message, '', $code, $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = findModel($this->eloquentModel, $id);
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
        return Response::updated(updateElement(findModel($this->eloquentModel, $id), $request->input()));
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
      return Response::delete(deleteModel($this->eloquentModel, $id));
        //
    }
}
