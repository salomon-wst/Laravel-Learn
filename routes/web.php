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
// Route::get('/user', 'HomeController@index')->name('user_dashboard');
// user protected routes
Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
    Route::get('/', 'HomeController@index')->name('user_dashboard');
    Route::post('/update', 'HomeController@updateProfile')->name('update_profile');
});

// admin protected routes
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin_dashboard');
    Route::get('/handle/{id}', 'AdminController@handleuser')->name('handle_user');
    Route::get('/profile', 'AdminController@profile')->name('profile_admin');
    Route::post('/update', 'AdminController@updateProfile')->name('update_admin');
    Route::get('/add', 'AdminController@adduser')->name('add_user');
    Route::post('/save', 'AdminController@saveuser')->name('save_user');
});
