<?php

use Illuminate\Http\Request;

Route::group(['prefix' => '/v1'], function(){
    // Route::post('/resourse/uploadFile', 'AdminControllers\AttachmentsController@uploadFile')->name('attachments.file.upload');
    Route::post('auth', 'Api\V1\LoginController@login');    
    // Route::get('auth', 'Api\V1\LoginController@checkUserByToken')->middleware('auth:api');
    Route::apiResource('ascriptions', 'Api\V1\AscriptionsController');
    Route::apiResource('categories', 'Api\V1\CategoriesController');
    Route::apiResource('courses', 'Api\V1\CoursesController');
    Route::get('courses/{course_id}/modules', 'Api\V1\CoursesController@showModules');
    Route::get('modules/{module_id}/evaluations', 'Api\V1\ModulesController@showEvaluations');
    Route::get('evaluations/{evaluation_id}/questions', 'Api\V1\EvaluationsController@showQuestions');
    Route::get('questions/{question_id}/options', 'Api\V1\QuestionsController@showOptions');
    Route::post('enrollments', 'Api\V1\CoursesController@enrolUsers');
    Route::apiResource('diplomas', 'Api\V1\DiplomasController');
    Route::apiResource('experts', 'Api\V1\ExpertsController');
    Route::apiResource('modules', 'Api\V1\ModulesController');
    Route::apiResource('notifications', 'Api\V1\NotificationsController');
    Route::apiResource('options', 'Api\V1\OptionsController');
    Route::apiResource('questions', 'Api\V1\QuestionsController');
    Route::apiResource('references', 'Api\V1\ReferencesController');
    Route::apiResource('resources', 'Api\V1\ResourcesController');
    Route::apiResource('settings', 'Api\V1\SettingsController');
    Route::apiResource('specialties', 'Api\V1\SpecialtiesController');
    Route::apiResource('states', 'Api\V1\StatesController');
    Route::apiResource('tags', 'Api\V1\TagsController');
    Route::apiResource('users', 'Api\V1\UsersController');
    Route::group(['middleware' => 'auth:api'], function(){

        
        Route::group(['middleware' => 'admin.api'], function() {
            Route::get('admin', function(){
                return "Eres un administrador";
            });
        });
    });
});