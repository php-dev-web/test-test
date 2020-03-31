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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:client', 'task.owner'], 'prefix'=>'client','as'=>'client.'], function() {
	Route::resource('my-tasks', 'MyTasksController', ['except' => ['update', 'edit']]);
	Route::post('/sendMessage/{my_task}', 'MessagesController@sendMessage')->name('my-tasks.sendMessage');
	Route::get('/closeTask/{my_task}', 'MyTasksController@closeTask')->name('my-tasks.closeTask');
});

Route::group(['middleware' => ['role:manager'], 'prefix'=>'manager','as'=>'manager.'], function() {
	Route::resource('tasks', 'TasksController', ['except' => ['update', 'edit', 'destroy']]);
	Route::post('/sendMessage/{task}', 'MessagesController@sendMessage')->name('tasks.sendMessage');
});