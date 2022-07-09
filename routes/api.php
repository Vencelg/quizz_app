<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => ['auth:sanctum', 'isAdmin']], function () {
    Route::apiResources([
        'quizzes' => \App\Http\Controllers\QuizController::class,
        'questions' => \App\Http\Controllers\QuestionController::class,
        'answers' => \App\Http\Controllers\AnswerController::class,
    ]);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::delete('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('score/{id}', [\App\Http\Controllers\AuthController::class, 'showScore'])->middleware('auth:sanctum');
    Route::post('score', [\App\Http\Controllers\AuthController::class, 'storeScore'])->middleware('auth:sanctum');
});
