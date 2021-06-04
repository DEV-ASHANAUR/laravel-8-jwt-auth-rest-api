<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetRequestController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\StudentController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// auth routes

Route::group([
    'middleware' => 'api',
    'namespace' => 'app\Http\Controllers',
    'prefix' => 'auth'
],function($router){
    Route::post('login',[AuthController::class, 'login']);
    Route::post('register',[AuthController::class, 'register']);
    Route::post('logout',[AuthController::class, 'logout']);
    Route::get('profile',[AuthController::class, 'profile']);
    Route::post('refresh',[AuthController::class, 'refresh']);
    Route::post('sendPasswordResetLink',[PasswordResetRequestController::class, 'sendEmail']);
    Route::post('resetPassword',[ChangePasswordController::class, 'passwordResetProcess']);
});

//todo routes

Route::group([
    'middleware' => 'api'
],function($router){
    Route::resource('todos', TodoController::class);
});

//student

Route::group([
    'prefix'=>'student'
],function($router){
    Route::resource('info', StudentController::class);
});
