<?php

Route::get('/', 'HomeController@index')->name('welcome');	// Acá se pondrá la página inicial, con login
Route::get('/get-response/{url}', 'AdminControllers\UsersController@getResponse')->name('get.response');  // Para verificación de cédula
Route::get('/registro', function () { return view('Users\check-valid-user'); } );

Route::get('/denied', function(){  return view('errors.denied');  })->middleware('auth')->name('permission.denied');

// Route::get('/student-courses','Users_Pages\CoursesController@index');
// Route::get('/student-home','Users_Pages\CoursesController@recommendations');
// Route::get('/student-courses/{id}','Users_Pages\CoursesController@show');
// Route::get('/student-experts','Users_Pages\ExpertsController@index');
// Route::get('/student-experts/{id}','Users_Pages\ExpertsController@show');

// Route::get('/login', function(){ return view('login/login'); })->name("form.login")->middleware('guest');
Route::post('/login','LoginController@authenticate')->middleware('guest')->name("request.login");

Route::group(['middleware' => ['auth']], function () {

	Route::get('/logout','LoginController@userLogout')->name("logout");
	
	Route::group(['prefix' => '/admin' , 'middleware' => ['admin']], function () {
		Route::get('/dashboard', function (){ return view('dashboard/dashboard'); })->name('admin.dashboard');
		Route::post('/attachments/uploadFile', 'AdminControllers\AttachmentsController@uploadFile')->name('attachments.file.upload');
		Route::get('/modules/{module}/manage-experts/', 'AdminControllers\ModulesController@listExperts')->name('list.experts.for.module');
		Route::get('/modules/{module}/resources/{resource}/change-weight/{new_weight}', 'AdminControllers\ResourcesController@changeWeight')
			->name('change.resource.weight');
		Route::get('/modules/{module}/order-resources/', 'AdminControllers\ModulesController@orderResources')->name('order.module.resources');
		Route::get('/experts/{expert_id}/list-specialties', 'AdminControllers\ExpertsController@listSpecialties')->name('list.specialties.for.expert');
		Route::get('/experts/{expert_id}/list-modules', 'AdminControllers\ExpertsController@listModules')->name('list.modules.for.expert');
		Route::get('/experts/{expert_id}/attach-module/{module_id}', 'AdminControllers\ExpertsController@attachModule')->name('attach.module.to.expert');
		Route::get('/experts/{expert_id}/detach-module/{module_id}', 'AdminControllers\ExpertsController@detachModule')->name('detach.module.to.expert');
		Route::get('/experts/{expert_id}/attach-specialty/{module_id}', 'AdminControllers\ExpertsController@attachSpecialty')->name('attach.specialty.to.expert');
		Route::get('/experts/{expert_id}/detach-specialty/{module_id}', 'AdminControllers\ExpertsController@detachSpecialty')->name('detach.specialty.to.expert');
		Route::get('/experts/{expert_id}/attach-module/{module_id}', 'AdminControllers\ExpertsController@attachModule')->name('attach.module.to.expert');
		Route::get('/experts/{expert_id}/detach-module/{module_id}', 'AdminControllers\ExpertsController@detachModule')->name('detach.module.to.expert');
		Route::get('/users/list-for-ascription/{ascription_id}', 'AdminControllers\UsersController@listForAscription')->name('list.users.for.ascriptions');
		Route::post('/upload-resource', 'AdminControllers\ResourcesController@uploadResource')->name('upload.resource');
		Route::resource('modules/{module_id}/resources', 'AdminControllers\ResourcesController');
		Route::resource('modules/{module}/references', 'AdminControllers\ReferencesController');
		Route::resource('/evaluations', 'AdminControllers\EvaluationsController');
		Route::resource('/experts', 'AdminControllers\ExpertsController');
		Route::resource('/ascriptions', 'AdminControllers\AscriptionsController');
		Route::resource('/modules', 'AdminControllers\ModulesController');
		Route::resource('/specialties', 'AdminControllers\SpecialtiesController');
		Route::get('/courses/add-to-ascription/{ascription_id}', 'AdminControllers\coursesController@listForAscription')->name('list.courses.for.ascription');
		Route::get('/courses/create-for-ascription/{ascription_id}', 'AdminControllers\coursesController@createForAscription')->name('course.form.for.ascription');
		Route::post('/courses/add-to-ascription', 'AdminControllers\coursesController@addToAscription')->name('add.course.to.ascription');
		Route::get('/courses/relate-to-ascription/{course_id}/{ascription_id}', 'AdminControllers\coursesController@relateToAscription')
			->name('relate.course.to.ascription');
		Route::get('/courses/dissociate-of-ascription/{course_id}/{ascription_id}', 'AdminControllers\coursesController@dissociateOfAscription')
			->name('dissociate.course.of.ascription');
		Route::resource('/courses','AdminControllers\CoursesController');
		Route::resource('/categories','AdminControllers\CategoriesController');
		Route::get('/users/reset-default-password-to/{user}', 'AdminControllers\UsersController@resetDefaultPassword')->name('reset.default.password');
		Route::resource('/users','AdminControllers\UsersController');
		Route::resource('/attachments', 'AdminControllers\AttachmentsController');
		Route::get('/options/create-for-question/{id}', 'AdminControllers\OptionsController@createFor')->name('options.createfor');
		Route::resource('/options','AdminControllers\OptionsController');
		Route::resource('/evaluations','AdminControllers\EvaluationsController');
		Route::resource('/questions', 'AdminControllers\QuestionsController');
	});



	Route::group([ 'prefix' => '/{adscription_slug}', 'middleware' => ['student']], function () {
		Route::get('/cursos', 'Users_Pages\CoursesController@index')->name('student.own.courses');
		Route::get('/cursos/{course_slug}', 'Users_Pages\CoursesController@show')->name('student.show.course'); // or slug
		Route::get('/home','Users_Pages\CoursesController@recommendations')->name('student.home');
		Route::get('/expertos','Users_Pages\ExpertsController@index')->name('student.show.experts');
		Route::get('/ver-experto/{expert_slug}','Users_Pages\ExpertsController@show')->name('student.show.expert');
	});

});
