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
Route::resource('/courses','CoursesController');
Route::resource('/categories','CategoriesController');
Route::resource('/users','UsersController');
Route::get('/pruebas',function(){
	return view('courses.prueba');
});
Route::post('/courses/uploadImage','CoursesController@uploadImage');
Route::post('/categories/uploadImage','CategoriesController@uploadImage');
Route::post('/users/uploadImage','UsersController@uploadImage');