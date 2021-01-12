<?php

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

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/schedule_view', 'ScheduleViewController@show');

Route::get('/schedule', 'ScheduleController@show');
Route::post('/schedule/add', 'ScheduleController@add');
Route::post('/schedule/remove', 'ScheduleController@remove');
Route::post('/schedule/edit', 'ScheduleController@edit');

Route::get('/lessons', 'LessonsController@show');
Route::post('/lessons/add', 'LessonsController@add');
Route::post('/lessons/remove', 'LessonsController@remove');
Route::post('/lessons/edit', 'LessonsController@edit');

Route::get('/subjects', 'SubjectsController@show');
Route::post('/subjects/add', 'SubjectsController@add');
Route::post('/subjects/remove', 'SubjectsController@remove');
Route::post('/subjects/edit', 'SubjectsController@edit');

Route::get('/teachers', 'TeachersController@show');
Route::post('/teachers/add', 'TeachersController@add');
Route::post('/teachers/remove', 'TeachersController@remove');
Route::post('/teachers/edit', 'TeachersController@edit');

Route::get('/groups', 'GroupsController@show');
Route::post('/groups/add', 'GroupsController@add');
Route::post('/groups/remove', 'GroupsController@remove');
Route::post('/groups/edit', 'GroupsController@edit');

Route::get('/rooms', 'RoomsController@show');
Route::post('/rooms/add', 'RoomsController@add');
Route::post('/rooms/remove', 'RoomsController@remove');
Route::post('/rooms/edit', 'RoomsController@edit');