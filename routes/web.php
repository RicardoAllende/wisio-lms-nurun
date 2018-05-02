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
Route::get('/', function(){
	return view('dashboard/welcome');
})->name("welcome");

Route::get('/d', function(){ // Intento de descarga de archivo no público
	$pathToFile = storage_path().'\app\resources\FvFG5Un7TFpHUoAaKPRDtulUMlI5K88Ht73LyKre.pdf';
	return response()->download($pathToFile);
});
Route::get('/denied', function(){
	return view('errors.denied');
})->middleware('auth')->name('permission.denied');
Route::get('/login', function(){ return view('login/login'); })->name("form.login")->middleware('guest');
Route::post('/login','LoginController@authenticate')->middleware('guest')->name("request.login");
Route::post('/upload-resource', 'ResourcesController@uploadResource')->name('upload.resource');
Route::resource('resources', 'ResourcesController');

Route::group(['middleware' => ['auth']], function () {
	Route::get('/logout','LoginController@userLogout')->name("logout");
	Route::get('/dashboard', 'HomeController@index')->name('dashboard');
	Route::group(['prefix' => '/admin' , 'middleware' => ['admin']], function () {
		Route::post('/attachments/uploadFile', 'AttachmentsController@uploadFile')->name('attachments.file.upload');
		Route::post('/users/uploadCSV','UsersController@uploadCSV')->name("uploaduserscsv");
		Route::get('/users/downloadCSV','UsersController@downloadCSV')->name("downloadcsv");
		Route::get('/users/import',function(){	return view("Users.massiveimport");	})->name("formmassiveimport");
		Route::get('/uploadQuestions','QuestionsController@formGift')->name("form.upload.questions");
		Route::post('/uploadQuestions','QuestionsController@uploadQuestions')->name("uploadquestions");
		Route::resource('/evaluations', 'EvaluationsController');
		Route::resource('/ascriptions', 'AscriptionsController');
		Route::resource('/modules', 'ModulesController');
		Route::get('/courses/add-to-ascription/{ascription_id}', 'coursesController@addToAscription')->name('add.courses.to.ascription');
		Route::get('/courses/create-for-ascription/{ascription_id}', 'coursesController@createForAscription')->name('create.course.for.ascription');
		Route::resource('/courses','CoursesController');
		Route::resource('/categories','CategoriesController');
		Route::resource('/users','UsersController');
		Route::resource('/answers','AnswersController');
		Route::resource('/attachments', 'AttachmentsController');
		Route::get('/options/createfor/{id}', 'OptionsController@createFor')->name('options.createfor');
		Route::resource('/options','OptionsController');
		Route::resource('/evaluations','EvaluationsController');
		Route::get('/questions/create-for-quiz/{quiz_id}', 'QuestionsController@createQuestionForQuiz')->name('form.create.questions.for.quiz');
		Route::resource('/questions', 'QuestionsController');
		Route::post('/courses/uploadImage','CoursesController@uploadImage');
		Route::post('/categories/uploadImage','CategoriesController@uploadImage');
		Route::post('/users/uploadImage','UsersController@uploadImage');
	});
	Route::group(['prefix' => '/student' , 'middleware' => ['student']], function () {
		
	});
});
