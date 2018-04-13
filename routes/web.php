<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function(){ return view('login/login'); })->name("welcome");
Route::get('/login', function(){ return view('login/login'); })->name("form.login");
Route::post('/login','LoginController@authenticate')->name("request.login");
Route::get('/logout','LoginController@userLogout')->name("logout");

Route::group(['middleware' => ['auth']], function () {
    Route::post('/users/uploadCSV','UsersController@uploadCSV')->name("uploaduserscsv");
	Route::get('/users/downloadCSV','UsersController@downloadCSV')->name("downloadcsv");
	Route::get('/users/import',function(){	return view("Users.massiveimport");	})->name("formmassiveimport");
	Route::get('/uploadQuestions','QuestionsController@index')->name("form.upload.questions");
	Route::post('/uploadQuestions','QuestionsController@uploadQuestions')->name("uploadquestions");

	Route::resource('/quizzes','QuizzesController');
	Route::resource('/courses','CoursesController');
	Route::resource('/categories','CategoriesController');
	Route::resource('/users','UsersController');
	Route::get('/pruebas',function(){
		return view('courses.prueba');
	});
	Route::post('/courses/uploadImage','CoursesController@uploadImage');
	Route::post('/categories/uploadImage','CategoriesController@uploadImage');
	Route::post('/users/uploadImage','UsersController@uploadImage');
});