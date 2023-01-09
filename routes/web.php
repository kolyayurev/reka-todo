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

Auth::routes([
    'reset' => false,
]);

Route::group(['prefix' => 'todo','as'=>'todo.','namespace'=>'App\Http\Controllers'],function() {
    Route::get('/', 'TodoController@index')->name('index');
    Route::get('/board/{id}', 'TodoController@board')->name('board');
    Route::get('/board/{id}/permissions', 'TodoController@permissions')->name('board.permissions');
});



Route::group(['prefix' => 'ajax','as'=>'ajax.','namespace'=>'App\Http\Controllers\Ajax'],function() {
    Route::group(['prefix' => 'todo','as'=>'todo.','namespace'=>'Todo'],function() {
        Route::get('board/{id}', 'BoardController@show')->name('show');
        Route::group(['prefix' => 'card','as'=>'card.'],function() {
            Route::post('/', 'CardController@store')->name('store');
            Route::post('/{id}', 'CardController@update')->name('update');
            Route::put('/{id}/done', 'CardController@done')->name('done');
            Route::put('/{id}/undone', 'CardController@undone')->name('undone');
            Route::delete('/{id}', 'CardController@delete')->name('delete');
        });
    });
});
