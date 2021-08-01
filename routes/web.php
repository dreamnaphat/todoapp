<?php

use Illuminate\Support\Facades\Route;
use App\Models\Todo;
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
    $todos = Todo::orderBy('status', 'DESC')->simplePaginate(10);
    return view('welcome')->with(['todos' => $todos]);
});

Route::post('new-todo','App\Http\Controllers\TodoController@create');
Route::post('update','App\Http\Controllers\TodoController@updateStatus');
Route::post('delete','App\Http\Controllers\TodoController@deleteTodo');
Route::post('delete-all','App\Http\Controllers\TodoController@deleteAllTodo');
