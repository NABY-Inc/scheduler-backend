<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::post('/login-user', 'appController@login')->name('login.user');
Route::get('/{any}', 'appController@index')->where('any','.*');
// Route::get('/department', 'pagesController@departmentIndex')->name('department.index');
// Route::get('/courses', 'pagesController@coursesIndex')->name('courses.index');
// Route::get('/lecturers', 'pagesController@lecturersIndex')->name('lecturers.index');
// Route::get('/venue', 'pagesController@venueIndex')->name('venue.index');
// Route::get('/time-stand', 'pagesController@timestandIndex')->name('timestand.index');
// Route::get('/schedule-time-table', 'pagesController@scheduleIndex')->name('schedule.index');
// Route::get('/show-time-table', 'pagesController@scheduleShow')->name('schedule.show');

// sudo chmod 777 /Applications/XAMPP/Xamppfiles/htdocs/schedular/public/uploads/folder_name


