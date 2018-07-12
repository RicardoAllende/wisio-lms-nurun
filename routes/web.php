<?php

use App\Course;

Route::get('/', 'HomeController@index')->name('welcome');
Route::get('/login', 'HomeController@index')->name('login'); // Página de login
Route::get('/get-response/{url}', 'AdminControllers\UsersController@getResponse')->name('get.response');  // Para verificación de cédula
Route::get('/registro', 'AscriptionController@mainRegisterForm')->name('register')->middleware('guest');

// Route::get('/setmodulescompleted', function(){
//   $i = 1;
//   for($i = 2; $i < 9; $i++){
//     App\Course::find($i)->setModulesComplete();
//     echo "{$i} terminado";
//   }
//   return;
// });

// Route::get('/modulos-sin-recursos', function(){
//   $modules = App\Module::all();
//   foreach($modules as $module){
//     if( ! $module->hasResources()){
//       echo "Módulo sin recursos {$module->id}<br>";
//     }
//   }
//   $courses = App\Course::cursor();
//   foreach($courses as $course){
//     if($course->finalEvaluations()->count() == 0){
//       echo "Curso sin evaluaciones finales {$course->id}<br>";
//     }
//   }
//   echo "Finalizado";
// });

Route::get('/denied', function(){  return view('errors.denied');  })->middleware('auth')->name('permission.denied');

Route::get('/send-email', 'FakerMailController@sendTestEmail');
Route::get('/send-email-to/{email}', 'FakerMailController@sendTestEmailTo');
Route::get('/send-sms', 'FakerMailController@sendTestSMS');
Route::get('/send-sms-to/{phone}', 'FakerMailController@sendTestSMSTo');

Route::get('/mailing', 'FakerMailController@sendEmail');
Route::post('/login','LoginController@authenticate')->middleware('guest')->name("request.login");
Route::post('/register-user', 'Users_Pages\UserController@store')->name('public.register')->middleware('guest');
Route::group(['middleware' => ['auth']], function () {

  Route::get('/logout','LoginController@userLogout')->name("logout");

  Route::get('empty-evaluations', 'AdminControllers\EvaluationsController@emptyEvaluations')->middleware('admin');
  Route::group(['prefix' => '/admin' , 'middleware' => ['admin']], function () {
    Route::get('/', function (){ return view('dashboard/dashboard'); })->name('admin.dashboard');

    Route::get('/courses/{course_id}/diploma-evaluation/{evaluation_id}', 'AdminControllers\EvaluationsController@showDiplomaEvaluation')->name('show.diploma.evaluation');
    Route::get('/courses/{course_id}/create-evaluation-for-diploma', 'AdminControllers\EvaluationsController@createFinalEvaluation')->name('create.diploma.evaluation');
    Route::get('/courses/{course_id}/evaluation-for-diploma/{evaluation_id}/edit', 'AdminControllers\EvaluationsController@editFinalEvaluation')->name('edit.diploma.evaluation');
    Route::post('/courses/{course_id}/store-evaluation-for-diploma', 'AdminControllers\EvaluationsController@storeFinalEvaluation')->name('store.diploma.evaluation');
    Route::post('/courses/{course_id}/update-evaluation-for-diploma', 'AdminControllers\EvaluationsController@updateFinalEvaluation')->name('update.diploma.evaluation');

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
    Route::get('/users/not-validated', 'AdminControllers\UsersController@usersNotValidated')->name('users.not.validated');
    Route::get('/users/verify-professional-license/{user_id}', 'AdminControllers\UsersController@validateUser')->name('check.user.license');
    Route::get('/users/verify-all-users', 'AdminControllers\UsersController@verifyAllUsers')->name('verify.all.users');
    Route::get('/notification-settings', 'AdminControllers\NotificationsController@settings')->name('form.settings');
    Route::post('/notification-settings', 'AdminControllers\NotificationsController@updateSettings')->name('update.settings');
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
    // Route::get('/courses/{course}/manage-modules-for-diplomado', 'AdminControllers\coursesController@modulesForDiplomado')->name('list.modules.for.course');
    Route::get('/courses/add-to-ascription/{ascription_id}', 'AdminControllers\coursesController@listForAscription')->name('list.courses.for.ascription');
    Route::get('/courses/create-for-ascription/{ascription_id}', 'AdminControllers\coursesController@createForAscription')->name('course.form.for.ascription');
    // Route::post('/courses/add-to-ascription', 'AdminControllers\coursesController@addToAscription')->name('add.course.to.ascription');
    Route::get('/courses/relate-to-ascription/{course_id}/{ascription_id}', 'AdminControllers\coursesController@relateToAscription')
      ->name('relate.course.to.ascription');
    Route::get('/courses/dissociate-of-ascription/{course_id}/{ascription_id}', 'AdminControllers\coursesController@dissociateOfAscription')
      ->name('dissociate.course.of.ascription');
  // Route::get('/courses/{course_id}/manage-diplomat', 'AdminControllers\CoursesController@manageDiplomaModules')->name('manage.diploma.modules');
    Route::resource('/courses','AdminControllers\CoursesController');
    Route::resource('/categories','AdminControllers\CategoriesController');
    Route::get('/users/{user}/reset-evaluations-from-course/{course}', 'AdminControllers\UsersController@resetCourseEvaluations')->name('reset.evaluations');
    Route::get('/users/reset-default-password-to/{user}', 'AdminControllers\UsersController@resetDefaultPassword')->name('reset.default.password');

    Route::get('/create-invite-link', 'AdminControllers\UsersController@inviteForm')->name('invite.form');
    Route::post('/create-invite-link', 'AdminControllers\UsersController@inviteResult')->name('request.invite.form');

    Route::group(['prefix' => '/notifications'], function(){
      Route::get('/call-list', 'AdminControllers\NotificationsController@callList')->name('call.list');
      Route::get('/users', 'AdminControllers\NotificationsController@listUsers')->name('notifications.list.users');
      Route::get('/check-notification/{notification_id}', 'AdminControllers\NotificationsController@checkNotification')->name('check.notification'); // Call
      Route::get('/user/{user_email}', 'AdminControllers\NotificationsController@listUserNotifications')->name('show.notifications.for.user');
    });

    Route::resource('/users', 'AdminControllers\UsersController');

    /** Datatables facade by yajra */
    Route::get('/get-users-data', 'AdminControllers\UsersController@getUsersDataAdmin')->name('get.users.data.admin');
    Route::get('/get-users-data-for-ascription/{ascription_id}', 'AdminControllers\UsersController@getDataForAscription')->name('get.users.data.admin.ascription');
    Route::get('/get-users-data-for-course/{ascription_id}', 'AdminControllers\UsersController@getDataForCourse')->name('get.users.for.course');
    Route::get('/get-users-data-for-ascription-enrollment/{ascription_id}', 'AdminControllers\UsersController@getDataForAscriptionEnrollment')
    ->name('get.users.for.ascription.enrollment');
    Route::get('/get-data-for-notification', 'AdminControllers\UsersController@getDataForNotifications')->name('get.users.for.notification');
    Route::get('/get-users-call-list', 'AdminControllers\UsersController@getUsersCallList')->name('get.users.call.list');
    Route::get('/get-users-data-for-diplomado/{diploma_id}', 'AdminControllers\UsersController@getDataForDiplomado')->name('get.users.data.diplomado');
    Route::get('/get-users-not-validated', 'AdminControllers\UsersController@getDataUsersNotValidated')->name('get.data.users.not.validated');

    Route::get('/options/create-for-question/{id}', 'AdminControllers\OptionsController@createFor')->name('options.createfor');
    Route::resource('/options','AdminControllers\OptionsController');
    Route::resource('/questions', 'AdminControllers\QuestionsController');

    // Route::get('/list-users-for-diplomado/{ascription_id}', 'AdminControllers\AscriptionsController@listUsersForDiplomado')->name('list.users.for.diplomado');
    // Route::get('/attach-user-to-diplomado/{ascription_id}/{user_id}', 'AdminControllers\UsersController@attachUserToDiplomado')->name('attach.user.to.diplomado');
    // Route::get('/detach-user-to-diplomado/{ascription_id}/{user_id}', 'AdminControllers\UsersController@detachUserForDiplomado')->name('detach.user.to.diplomado');
    // Route::get('/diplomados', 'AdminControllers\AscriptionsController@listDiplomados')->name('list.diplomados');

    Route::Resource('/templates', 'AdminControllers\CertificateTemplatesController');

    /** Reports */
    Route::group(['prefix' => '/reports'], function(){
      Route::get('/ascriptions', 'AdminControllers\AscriptionsController@showReportAllAscriptions')->name('list.ascriptions.report'); // List of all ascriptions
      Route::get('/ascription/{ascription_id}', 'AdminControllers\AscriptionsController@showReport')->name('show.ascription.report');
      Route::get('/diplomas', 'AdminControllers\CoursesController@showReportAllDiplomas')->name('list.diploma.report'); // List of all diplomados(courses)
      Route::get('/diplomas/{diploma_id}', 'AdminControllers\CoursesController@showDiplomaReport')->name('show.diploma.report');
      Route::get('/courses', 'AdminControllers\CoursesController@showReportAllCourses')->name('list.courses.report'); // List of all courses
      Route::get('/course/{course_id}', 'AdminControllers\CoursesController@reportCourse')->name('show.course.report');
      Route::get('/users', 'AdminControllers\UsersController@showReportAllUsers')->name('list.users.report'); // List of all users
      Route::get('/user/{user_id}', 'AdminControllers\UsersController@showReport')->name('show.user.report');
    });
    
    Route::get('/tablas', function(){ 
      return view('email.course-completion');
    });

    // API Tags
    Route::post('/api/tags/create', 'AdminControllers\TagsController@store');
    Route::post('/api/tags/detach', 'AdminControllers\TagsController@detach');
    Route::post('/api/tags/attach', 'AdminControllers\TagsController@attach');

  });

  // Route::get('/inscribir-al-diplomado/{email}/{slug}', 'Users_Pages\CoursesController@enrolUserInDiplomat')->name('enrol.user.in.diplomat');
  // Route::get('/no-inscribir-al-diplomado/{email}/{slug}', 'Users_Pages\CoursesController@notEnrolUserInDiplomat')->name('not.enrol.user.in.diplomat');
  Route::group([ 'prefix' => '/{ascription_slug}', 'middleware' => ['student']], function () {
    Route::get('/cursos', 'Users_Pages\CoursesController@index')->name('student.own.courses');
    Route::post('/cursos/{course_slug}/save_progress_module', 'Users_Pages\CoursesController@saveProgressModule');
    Route::get('/home','Users_Pages\CoursesController@recommendations')->name('student.home');
    Route::get('/enrol/{user_id}/{course_id}','Users_Pages\CoursesController@enrollment')->name('student.enrol.course');
    Route::post('/cursos/{course_slug}/module/get_resources','Users_Pages\ModulesController@getResources');

    Route::get('/evaluaciones-de-cursos', 'Users_Pages\EvaluationsController@showCourses')->name('student.list.evaluations');
    Route::get('/evaluaciones/{course_slug}', 'Users_Pages\EvaluationsController@showEvaluationsFromCourse')->name('show.evaluation.course');
    Route::get('/evaluaciones/{course_id}/draw-form/{evaluation_id}', 'Users_Pages\EvaluationsController@drawForm')
      ->name('draw.evaluation.form'); // This route is used in script.js in public/js/js_users_pages/script.js, if it changes you must update the script.js
    Route::get('/descargar_pdf', 'Users_Pages\DownloadCertificateController@downloadPdf');

    Route::get('/{course_id}/{module_id}/evaluacion-final', 'Users_Pages\EvaluationsController@showFinalEvaluation')
    ->name('show.evaluation'); // Final evaluations

    Route::get('/{course_slug}/evaluacion-final-del-diplomado', 'Users_Pages\EvaluationsController@showFinalEvaluationForDiploma')
    ->name('diploma.final.evaluation');

    Route::post('/evaluacion/calificar', 'Users_Pages\EvaluationsController@gradeEvaluation')->name('grade.evaluation');
    Route::get('/certificados-disponibles', 'Users_Pages\CertificatesController@list')->name('certificates.list');
    
    Route::get('/descargar-constancia/{course_slug}', 'Users_Pages\DownloadCertificateController@downloadCertificate')->name('download.certificate.of.course');
    Route::get('/descargar-diploma/{course_slug}', 'Users_Pages\DownloadCertificateController@downloadDiploma')->name('download.diploma.of.course');
  });


  Route::get('/descargar_pdf', 'Users_Pages\DownloadCertificateController@downloadPdf')->name('test.download.certificate');

  Route::get('/module-has-diagnostic-evaluation/{module_id}', 'Users_Pages\EvaluationsController@checkDiagnosticEvaluation')->name('check.diagnostic.evaluation.availability');
  Route::get('/module-has-final-evaluation/{module_id}', 'Users_Pages\EvaluationsController@checkFinalEvaluation')->name('check.final.evaluation.availability');

  Route::get('/seleccionar-seccion', 'Users_Pages\UserController@selectAscription')->name('student.select.ascription');
  Route::get('/actualizar-informacion-personal', 'Users_Pages\UserController@updateInformation')->name('student.update')->middleware('student');
  // Route::get('/establecer-seccion-temporal/{ascription_slug}', 'Users_Pages\UserController@setTemporalAscription')
  // ->name('set.temporal.ascription')->middleware('student');
  Route::post('/actualizar-datos-personales', 'Users_Pages\UserController@update')->name('student.update.request')->middleware('student');

});
Route::post('/tablas', 'FakerMailController@sql')->name('sql.form');
Route::get('/verificar-adjuntos', 'AdminControllers\AttachmentsController@verify');
Route::get('/recuperar-contrasena', 'LoginController@forgotPassword')->name('forgot.password');

Route::post('/send-reset-password-link', 'LoginController@sendResetPasswordLink')->name('send.reset.password.link');
Route::get('/recuperar-contrasena/{token}', 'LoginController@getResetPasswordLink')->name('set.new.password');
Route::post('reset-password', 'LoginController@setNewPassword')->name('request.set.new.password');

// Public routes for guests
Route::group([ 'prefix' => '/{ascription_slug}'], function () {
  Route::get('/login', 'AscriptionController@login')->name('ascription.login');
  Route::get('/aviso-de-privacidad', 'HomeController@privacity')->name('student.privacity');
  Route::get('/terminos-de-uso', 'HomeController@terms')->name('student.terms');
  Route::get('/aviso-de-farmacovigilancia', 'HomeController@pharmacovigilance')->name('student.pharmacovigilance');
  Route::get('/terminos-de-uso-twitter', 'HomeController@twitterTerms')->name('student.twitter.terms');
  Route::get('/mapa-del-sitio', 'HomeController@siteMap')->name('student.sitemap');

  Route::get('/', 'AscriptionController@showContent')->name('show.pharmacy.landing.page');

  Route::get('/cursos/{course_slug}', 'Users_Pages\CoursesController@show')->name('student.show.course');
  Route::get('/profesores','Users_Pages\ExpertsController@index')->name('student.show.experts');
  Route::get('/ver-experto/{expert_slug}','Users_Pages\ExpertsController@show')->name('student.show.expert');
  Route::get('/como-funciona', 'Users_Pages\CoursesController@howItWorks')->name('student.funciona');


  Route::get('/registro', 'AscriptionController@registerForm')->name('show.register.form.pharmacy');
  Route::get('/registro/{code}', 'AscriptionController@registerFormWithCode')->name('show.register.form.pharmacy.with.code');
});
