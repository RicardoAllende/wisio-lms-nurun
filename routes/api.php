<?php

use Illuminate\Http\Request;

Route::group(['prefix' => '/v1'], function(){
    // Route::post('/resourse/uploadFile', 'AdminControllers\AttachmentsController@uploadFile')->name('attachments.file.upload');
    Route::post('auth', 'Api\V1\LoginController@login');    
    Route::get('auth', 'Api\V1\LoginController@checkUserByToken')->middleware('auth:api');
    Route::apiResource('ascriptions', 'Api\V1\AscriptionsController');
    Route::apiResource('categories', 'Api\V1\CategoriesController');
    Route::apiResource('courses', 'Api\V1\CoursesController');
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
        
        // Route::middleware(['lms'])->prefix('/lms')->group(function (){
        //     Route::apiResource('users', 'Api\V1\LMS\UsersController');
        //     Route::apiResource('courses', 'Api\V1\LMS\CoursesController');
        //     Route::apiResource('questions', 'Api\V1\LMS\QuestionsController');
        //     // Route::post('users/disable', 'Api\V1\LMS\EnrollmentsController@disable');
        //     Route::post('enrollments', 'Api\V1\LMS\EnrollmentsController@store');
        //     // Route::post('courses/disable', 'Api\V1\LMS\CoursesController@disable');
        // });

        // Route::middleware(['app'])->prefix('app')->group(function(){
        //     Route::get('achievements', 'Api\V1\App\AchievementsController@showAll');
        //     // Route::get('achievements/social/{achievement_name}', 'Api\V1\App\AchievementsController@setSocialAchievement');
        //     Route::post('sessions/results', 'Api\V1\App\CoursesController@sessionResults');
        //     Route::get('courses', 'Api\V1\App\CoursesController@index');
        //     Route::get('courses/completed', 'Api\V1\App\CoursesController@completedCourses');
        //     Route::post('profile/remember-me', 'Api\V1\App\UsersController@changeRememberMe');
        //     Route::apiResource('users', 'Api\V1\App\UsersController');
        //     Route::get('courses/{course_id}/questions', 'Api\V1\App\CoursesController@showQuestions');
        //     Route::get('courses/{course_id}/overview', 'Api\V1\App\CoursesController@overview');
        //     Route::get('courses/{course_id}/achievements', 'Api\V1\App\AchievementsController@index'); // Get all user achievements in the course
        //     Route::post('courses/{course_id}/achievements/set-hits', 'Api\V1\App\AchievementsController@setHits'); // Get all user achievements in the course
        //     Route::get('courses/{course_id}/achievements/available', 'Api\V1\App\AchievementsController@available'); // Get available achievements
        //     Route::post('courses/{course_id}/achievements/save', 'Api\V1\App\AchievementsController@store'); // Save an achievement
        //     Route::get('settings', 'Api\V1\App\SettingsController@getSettings');
        //     Route::post('settings', 'Api\V1\App\SettingsController@setSettings');
        //     Route::get('courses/{course_id}/achievements/stats', 'Api\V1\App\AchievementsController@courseStats');
        //     Route::post('questions', 'Api\V1\App\QuestionsController@saveQuestion');
        //     Route::get('overview', 'Api\V1\App\UsersController@index');
        //     Route::get('avatar', 'Api\V1\App\UsersController@getAvatar');
        //     Route::get('ranking', 'Api\V1\App\UsersController@getRanking');
        //     Route::post('users/avatar', 'AttachmentsController@store');
        //     Route::get('expo-push-token', 'Api\V1\App\UsersController@hasExpoPushToken');
        //     Route::post('expo-push-token', 'Api\V1\App\UsersController@setExpoPushToken');
        // });
    });
});