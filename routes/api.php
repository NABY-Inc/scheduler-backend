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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/login', function () {
    return true;
});

Route::resource('department', departmentController::class);

Route::resource('courses', courseController::class);

Route::resource('lecturer', lecturerController::class);
Route::post('lecturer/{id}', 'lecturerController@update'); // Purposely for update

Route::resource('venue', venueController::class);

Route::resource('timestand', timestandController::class);
