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

Route::domain('{slug}.'.config('constants.main_domain'))->group(function () {
    Route::get('student/{id}', function ($slug, $id) {
		return "Buscando la farmacia con el slug: {$slug},<br> información que se obtendrá del usuario: {$id}";
    })->name('subdomain');
});


Route::get('/denied', function(){  return view('errors.denied');  })->middleware('auth')->name('permission.denied');

Route::get('/student-login', function () {
	return view('users_pages/login/login');
});

Route::get('/student-courses','Users_Pages\CoursesController@index');
Route::get('/student-courses/{id}','Users_Pages\CoursesController@show');
Route::get('/student-experts','Users_Pages\ExpertsController@index');
Route::get('/student-experts/{id}','Users_Pages\ExpertsController@show');

Route::get('/login', function(){ return view('login/login'); })->name("form.login")->middleware('guest');
Route::post('/login','LoginController@authenticate')->middleware('guest')->name("request.login");

Route::group(['middleware' => ['auth']], function () {

	Route::get('/logout','LoginController@userLogout')->name("logout");
	Route::get('/dashboard', 'HomeController@index')->name('dashboard');

	Route::group(['prefix' => '/admin' , 'middleware' => ['admin']], function () {
		Route::post('/attachments/uploadFile', 'AttachmentsController@uploadFile')->name('attachments.file.upload');
		Route::get('/modules/{id}/manage-experts/', function($id){ return "Se ingresó ".$id; })->name('module');
		Route::get('/experts/{id}/list-specialties', 'ExpertsController@listSpecialties')->name('list.specialties.for.expert');
		Route::get('/experts/{id}/list-modules', 'ExpertsController@listModules')->name('list.modules.for.expert');
		Route::get('/experts/{expert_id}/attach-specialty/{module_id}', 'ExpertsController@attachSpecialty')->name('attach.specialty.to.expert');
		Route::get('/experts/{expert_id}/detach-specialty/{module_id}', 'ExpertsController@detachSpecialty')->name('detach.specialty.to.expert');
		Route::get('/experts/{expert_id}/attach-module/{module_id}', 'ExpertsController@attachModule')->name('attach.module.to.expert');
		Route::get('/experts/{expert_id}/detach-module/{module_id}', 'ExpertsController@detachModule')->name('detach.module.to.expert');
		Route::get('users/search-by-email/{email}', 'UsersController@searchUsersByEmail')
			->name('search.users.by.email');
		Route::get('users/search-by-name/{name}', 'UsersController@searchUsersByName')
			->name('search.users.by.name');
		Route::get('users/list-for-ascription/{ascription_id}/search-by-email/{email}', 'UsersController@lisetForAscriptionSearchByEmail')
			->name('list.users.for.ascription.search.by.email');
		Route::get('users/list-for-ascription/{ascription_id}/search-by-name/{name}', 'UsersController@lisetForAscriptionSearchByName')
			->name('list.users.for.ascription.search.by.name');
		Route::get('/users/list-for-ascription/{ascription_id}', 'UsersController@listForAscription')->name('list.users.for.ascriptions');
		Route::get('/users/{user_id}/enroll-to-ascription/{ascription_id}', 'UsersController@enrollToAscription')->name('enroll.user.to.ascription');
		Route::get('/users/{user_id}/dissociate-of-ascription/{ascription_id}', 'UsersController@dissociateForAscription')->name('dissociate.user.for.ascription');
		Route::get('/users/import',function(){	return view("Users.massiveimport");	})->name("formmassiveimport");
		Route::get('/uploadQuestions','QuestionsController@formGift')->name("form.upload.questions");
		Route::post('/upload-resource', 'ResourcesController@uploadResource')->name('upload.resource');
		Route::resource('resources', 'ResourcesController');
		Route::post('/uploadQuestions','QuestionsController@uploadQuestions')->name("uploadquestions");
		Route::resource('/evaluations', 'EvaluationsController');
		Route::resource('/experts', 'ExpertsController');
		Route::resource('/ascriptions', 'AscriptionsController');
		Route::resource('/modules', 'ModulesController');
		Route::resource('/specialties', 'SpecialtiesController');

		Route::get('/modules/add-to-course/{course_id}', 'modulesController@listForCourse')->name('list.modules.for.course');
		Route::get('/modules/create-for-course/{course_id}', 'modulesController@createForCourse')->name('module.form.for.course');
		Route::post('/modules/add-to-course', 'modulesController@addToCourse')->name('add.module.to.course');
		Route::get('/modules/relate-to-course/{module_id}/{course_id}', 'modulesController@relateToCourse')->name('relate.module.to.course');
		Route::get('/modules/dissociate-of-course/{module_id}/{course_id}', 'modulesController@dissociateOfCourse')->name('dissociate.module.of.course');

		Route::get('/courses/add-to-ascription/{ascription_id}', 'coursesController@listForAscription')->name('list.courses.for.ascription');
		Route::get('/courses/create-for-ascription/{ascription_id}', 'coursesController@createForAscription')->name('course.form.for.ascription');
		Route::post('/courses/add-to-ascription', 'coursesController@addToAscription')->name('add.course.to.ascription');
		Route::get('/courses/relate-to-ascription/{course_id}/{ascription_id}', 'coursesController@relateToAscription')->name('relate.course.to.ascription');
		Route::get('/courses/dissociate-of-ascription/{course_id}/{ascription_id}', 'coursesController@dissociateOfAscription')->name('dissociate.course.of.ascription');
		Route::resource('/courses','CoursesController');
		Route::resource('/categories','CategoriesController');
		Route::resource('/users','UsersController');
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

	/**
	 * Special Landing Pages for the different pharmacies
	 */
	// Route::domain('{slug}.'.config('constants.main_domain'))->group(function () {
	// 	Route::get('student/{id}', function ($slug, $id) {
	// 		return "Buscando la farmacia con el slug: {$slug},<br> información que se obtendrá del usuario: {$id}";
	// 	})->name('subdomain');
	// 	// ...
	// })->middleware('pharmacy.doctor');

	Route::group(['prefix' => '/student' , 'middleware' => ['student']], function () {



	});
});
