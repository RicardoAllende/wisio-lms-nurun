<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/v1'], function(){
    Route::post('auth', 'Api\LoginController@login');    
    Route::get('auth', 'Api\LoginController@checkUserByToken')->middleware('auth:api');
    Route::apiResource('ascriptions', 'Api\AscriptionsController');
    Route::apiResource('categories', 'Api\CategoriesController');
    Route::apiResource('courses', 'Api\CoursesController');
    Route::apiResource('diplomas', 'Api\DiplomasController');
    Route::apiResource('experts', 'Api\ExpertsController');
    Route::apiResource('modules', 'Api\ModulesController');
    Route::apiResource('notifications', 'Api\NotificationsController');
    Route::apiResource('options', 'Api\OptionsController');
    Route::apiResource('questions', 'Api\QuestionsController');
    Route::apiResource('references', 'Api\ReferencesController');
    Route::apiResource('resources', 'Api\ResourcesController');
    Route::apiResource('settings', 'Api\SettingsController');
    Route::apiResource('specialties', 'Api\SpecialtiesController');
    Route::apiResource('states', 'Api\StatesController');
    Route::apiResource('tags', 'Api\TagsController');
    Route::apiResource('users', 'Api\UsersController');
    Route::group(['middleware' => 'auth:api'], function(){

        
        Route::group(['middleware' => 'admin.api'], function() {
            Route::get('admin', function(){
                return "Eres un administrador";
            });
        });
        
        // Route::middleware(['lms'])->prefix('/lms')->group(function (){
        //     Route::apiResource('users', 'Api\LMS\UsersController');
        //     Route::apiResource('courses', 'Api\LMS\CoursesController');
        //     Route::apiResource('questions', 'Api\LMS\QuestionsController');
        //     // Route::post('users/disable', 'Api\LMS\EnrollmentsController@disable');
        //     Route::post('enrollments', 'Api\LMS\EnrollmentsController@store');
        //     // Route::post('courses/disable', 'Api\LMS\CoursesController@disable');
        // });

        // Route::middleware(['app'])->prefix('app')->group(function(){
        //     Route::get('achievements', 'Api\App\AchievementsController@showAll');
        //     // Route::get('achievements/social/{achievement_name}', 'Api\App\AchievementsController@setSocialAchievement');
        //     Route::post('sessions/results', 'Api\App\CoursesController@sessionResults');
        //     Route::get('courses', 'Api\App\CoursesController@index');
        //     Route::get('courses/completed', 'Api\App\CoursesController@completedCourses');
        //     Route::post('profile/remember-me', 'Api\App\UsersController@changeRememberMe');
        //     Route::apiResource('users', 'Api\App\UsersController');
        //     Route::get('courses/{course_id}/questions', 'Api\App\CoursesController@showQuestions');
        //     Route::get('courses/{course_id}/overview', 'Api\App\CoursesController@overview');
        //     Route::get('courses/{course_id}/achievements', 'Api\App\AchievementsController@index'); // Get all user achievements in the course
        //     Route::post('courses/{course_id}/achievements/set-hits', 'Api\App\AchievementsController@setHits'); // Get all user achievements in the course
        //     Route::get('courses/{course_id}/achievements/available', 'Api\App\AchievementsController@available'); // Get available achievements
        //     Route::post('courses/{course_id}/achievements/save', 'Api\App\AchievementsController@store'); // Save an achievement
        //     Route::get('settings', 'Api\App\SettingsController@getSettings');
        //     Route::post('settings', 'Api\App\SettingsController@setSettings');
        //     Route::get('courses/{course_id}/achievements/stats', 'Api\App\AchievementsController@courseStats');
        //     Route::post('questions', 'Api\App\QuestionsController@saveQuestion');
        //     Route::get('overview', 'Api\App\UsersController@index');
        //     Route::get('avatar', 'Api\App\UsersController@getAvatar');
        //     Route::get('ranking', 'Api\App\UsersController@getRanking');
        //     Route::post('users/avatar', 'AttachmentsController@store');
        //     Route::get('expo-push-token', 'Api\App\UsersController@hasExpoPushToken');
        //     Route::post('expo-push-token', 'Api\App\UsersController@setExpoPushToken');
        // });
    });
});