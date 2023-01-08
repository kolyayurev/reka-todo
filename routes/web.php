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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'ajax','as'=>'ajax.','namespace'=>'App\Http\Controllers\Ajax'],function() {
    Route::group(['prefix' => 'todo','as'=>'todo.'],function() {
        Route::get('board', 'TodoController@board')->name('board');
        Route::group(['prefix' => 'card','as'=>'card.'],function() {
            Route::post('/', 'TodoController@cardStore')->name('store');
            Route::delete('/{id}', 'TodoController@cardDelete')->name('delete');
        });

    });
});
