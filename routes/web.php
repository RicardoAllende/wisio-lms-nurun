<?php

Route::get('/', 'HomeController@index')->name('welcome');	// Acá se pondrá la página inicial, con ruta a login
Route::get('/login', 'HomeController@index')->name('login'); // Página de login
Route::get('/get-response/{url}', 'AdminControllers\UsersController@getResponse')->name('get.response');  // Para verificación de cédula
Route::get('/registro', function () { return view('Users\register'); } )->name('register')->middleware('guest');

Route::get('/denied', function(){  return view('errors.denied');  })->middleware('auth')->name('permission.denied');

// Route::get('/login', function(){ return view('login/login'); })->name("form.login")->middleware('guest');
Route::post('/login','LoginController@authenticate')->middleware('guest')->name("request.login");
Route::post('/register-user', 'Users_Pages\UserController@store')->name('public.register')->middleware('guest');

Route::group(['middleware' => ['auth']], function () {

	Route::get('/logout','LoginController@userLogout')->name("logout");

	Route::group(['prefix' => '/admin' , 'middleware' => ['admin']], function () {
		Route::get('/', function (){ return view('dashboard/dashboard'); })->name('admin.dashboard');
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
		Route::get('/disable-ascription/{ascription_id}', 'AdminControllers\AscriptionsController@disableAscription')->name('disable.ascription');
		Route::get('/enable-ascription/{ascription_id}', 'AdminControllers\AscriptionsController@enableAscription')->name('enable.ascription');
		Route::get('/disable-user/{user_id}', 'AdminControllers\UsersController@disableUser')->name('disable.user');
		Route::get('/enable-user/{user_id}', 'AdminControllers\UsersController@enableUser')->name('enable.user');
		Route::get('/disable-course/{course_id}', 'AdminControllers\CoursesController@disableCourse')->name('disable.course');
		Route::get('/enablecourse/{course_id}', 'AdminControllers\CoursesController@enableCourse')->name('enable.course');
		Route::get('/users/list-for-ascription/{ascription_id}', 'AdminControllers\UsersController@listForAscription')->name('list.users.for.ascriptions');
		Route::post('/upload-resource', 'AdminControllers\ResourcesController@uploadResource')->name('upload.resource');
		Route::resource('modules/{module_id}/resources', 'AdminControllers\ResourcesController');
		Route::resource('modules/{module}/references', 'AdminControllers\ReferencesController');
		Route::resource('/evaluations', 'AdminControllers\EvaluationsController');
		Route::resource('/experts', 'AdminControllers\ExpertsController');
		Route::resource('/ascriptions', 'AdminControllers\AscriptionsController');
		Route::resource('/modules', 'AdminControllers\ModulesController');
		Route::resource('/specialties', 'AdminControllers\SpecialtiesController');
		Route::get('/courses/{course}/manage-users', 'AdminControllers\coursesController@listUsers')->name('list.users.for.course');
		Route::get('/courses/add-to-ascription/{ascription_id}', 'AdminControllers\coursesController@listForAscription')->name('list.courses.for.ascription');
		Route::get('/courses/create-for-ascription/{ascription_id}', 'AdminControllers\coursesController@createForAscription')->name('course.form.for.ascription');
		Route::post('/courses/add-to-ascription', 'AdminControllers\coursesController@addToAscription')->name('add.course.to.ascription');
		Route::get('/courses/relate-to-ascription/{course_id}/{ascription_id}', 'AdminControllers\coursesController@relateToAscription')
			->name('relate.course.to.ascription');
		Route::get('/courses/dissociate-of-ascription/{course_id}/{ascription_id}', 'AdminControllers\coursesController@dissociateOfAscription')
			->name('dissociate.course.of.ascription');
		Route::resource('/courses','AdminControllers\CoursesController');
		Route::resource('/categories','AdminControllers\CategoriesController');
		Route::get('/users/{user}/reset-evaluations-from-course/{course}', 'AdminControllers\UsersController@resetCourseEvaluations')->name('reset.evaluations');
		Route::get('/users/reset-default-password-to/{user}', 'AdminControllers\UsersController@resetDefaultPassword')->name('reset.default.password');
		Route::resource('/users','AdminControllers\UsersController');
		Route::get('/options/create-for-question/{id}', 'AdminControllers\OptionsController@createFor')->name('options.createfor');
		Route::resource('/options','AdminControllers\OptionsController');
		Route::resource('/questions', 'AdminControllers\QuestionsController');

		Route::get('/list-users-for-diplomado/{ascription_id}', 'AdminControllers\AscriptionsController@listUsersForDiplomado')->name('list.users.for.diplomado');
		Route::get('/attach-user-to-diplomado/{ascription_id}/{user_id}', 'AdminControllers\UsersController@attachUserToDiplomado')->name('attach.user.to.diplomado');
		Route::get('/detach-user-to-diplomado/{ascription_id}/{user_id}', 'AdminControllers\UsersController@detachUserForDiplomado')->name('detach.user.to.diplomado');
		Route::get('/diplomados', 'AdminControllers\AscriptionsController@listDiplomados')->name('list.diplomados');

		Route::Resource('/templates', 'AdminControllers\CertificateTemplatesController');

		/** Reports */
		Route::group(['prefix' => '/reports'], function(){
			Route::get('/ascriptions', 'AdminControllers\AscriptionsController@showReportAllAscriptions')->name('list.ascriptions.report'); // List of all ascriptions
			Route::get('/ascription/{ascription_id}', 'AdminControllers\AscriptionsController@showReport')->name('show.ascription.report'); 
			Route::get('/courses', 'AdminControllers\CoursesController@showReportAllCourses')->name('list.courses.report'); // List of all courses
			Route::get('/course/{course_id}', 'AdminControllers\CoursesController@reportCourse')->name('show.course.report');
			Route::get('/users', 'AdminControllers\UsersController@showReportAllUsers')->name('list.users.report'); // List of all users
			Route::get('/user/{user_id}', 'AdminControllers\UsersController@showReport')->name('show.user.report');
		});

	});

	Route::get('/search-experts/{search}', 'AdminControllers\ExpertsController@searchByName')->name('search.experts');

	// Search by name or by category
	Route::get('/search-courses/{search}', 'AdminControllers\CoursesController@searchCourses')->name('search.courses');

	Route::group([ 'prefix' => '/{ascription_slug}', 'middleware' => ['student']], function () {
		// Route::get('/actualizar', 'Users_Pages\UserController@updateInformation')->name('student.update');
		// Route::post('/actualizar_user', 'Users_Pages\UserController@updateInfo')->name('student.update.request');
		Route::get('/cursos', 'Users_Pages\CoursesController@index')->name('student.own.courses');
		Route::get('/cursos/{course_slug}', 'Users_Pages\CoursesController@show')->name('student.show.course'); // or slug
		Route::post('/cursos/{course_slug}/save_progress_module', 'Users_Pages\CoursesController@saveProgressModule');
		Route::get('/home','Users_Pages\CoursesController@recommendations')->name('student.home');
		Route::get('/expertos','Users_Pages\ExpertsController@index')->name('student.show.experts');
		Route::get('/ver-experto/{expert_slug}','Users_Pages\ExpertsController@show')->name('student.show.expert');
		Route::get('/como-funciona', 'Users_Pages\CoursesController@howItWorks')->name('student.funciona');
		Route::get('/enrol/{user_id}/{course_id}','Users_Pages\CoursesController@enrollment')->name('student.enrol.course');
		Route::post('/cursos/{course_slug}/module/get_resources','Users_Pages\ModulesController@getResources');

		Route::get('/evaluaciones-de-cursos', 'Users_Pages\EvaluationsController@showCourses')->name('student.list.evaluations');
		Route::get('/evaluaciones/{course_id}', 'Users_Pages\EvaluationsController@showEvaluationsFromCourse')->name('show.evaluation.course');
		Route::get('/evaluaciones/{course_id}/draw-form/{evaluation_id}', 'Users_Pages\EvaluationsController@drawForm')
			->name('draw.evaluation.form'); // This route is used in script.js in public/js/js_users_pages/script.js, if it changes you must update the script.js
		Route::get('/descargar_pdf', 'Users_Pages\DownloadCertificateController@downloadPdf');
		// Route::get('/evaluacion/{course_id}/{evaluation_id}', 'Users_Pages\EvaluationsController@showEvaluation')->name('show.evaluation');
		Route::post('/evaluacion/calificar', 'Users_Pages\EvaluationsController@gradeEvaluation')->name('grade.evaluation');
		Route::get('/certificados-disponibles', 'Users_Pages\CertificatesController@list')->name('certificates.list');
	});

	Route::get('/descargar_pdf', 'Users_Pages\DownloadCertificateController@downloadPdf')->name('test.download.certificate');

	Route::get('/module-has-diagnostic-evaluation/{module_id}', 'Users_Pages\EvaluationsController@checkDiagnosticEvaluation')->name('check.diagnostic.evaluation.availability');
	Route::get('/module-has-final-evaluation/{module_id}', 'Users_Pages\EvaluationsController@checkFinalEvaluation')->name('check.final.evaluation.availability');

	Route::get('/seleccionar-seccion', 'Users_Pages\UserController@selectAscription')->name('student.select.ascription');
	Route::get('/actualizar-informacion-personal', 'Users_Pages\UserController@updateInformation')->name('student.update')->middleware('student');
	Route::get('/establecer-seccion-temporal/{ascription_slug}', 'Users_Pages\UserController@setTemporalAscription')
	->name('set.temporal.ascription')->middleware('student');
	Route::post('/actualizar-datos-personales', 'Users_Pages\UserController@update')->name('student.update.request')->middleware('student');

});

/**
 *
 * For visitors, they can see the public courses
 */
Route::get('/cursos', 'Users_Pages\CoursesController@publicCourses')->name('public.courses');
Route::get('/verificar-adjuntos', 'AdminControllers\AttachmentsController@verify');
