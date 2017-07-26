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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/hello', function(){
    return Auth::user()->hello();
});

Route::group(['middleware' => 'auth'], function(){

    Route::get('/profile/{slug}', [
        'uses' => 'ProfileController@index',
        'as' => 'profile.index'
    ]);

    Route::get('/profile/edit/profile', [
        'uses' => 'ProfileController@edit',
        'as' => 'profile.edit'
    ]);

    Route::post('profile/update/profile', [
        'uses' => 'ProfileController@update',
        'as' => 'profile.update'
    ]);



});



