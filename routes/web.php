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

Route::resource('user','UserController');



Route::get('/profile', 'UserController@profile')->name('user.profile');
Route::post('/profile', 'UserController@post_profile')->name('user.postprofile');

Route::get('/password', 'UserController@change_password')->name('user.change_password');
Route::post('/password/post', 'UserController@change_password_post');

// =======axios request========
Route::get('getAllPermission', 'PermissionController@getAllPermission');
Route::post('postRole', 'RoleController@store');
Route::get('getAllUsers', 'UserController@getAllUsers');
Route::get('getAllRoles', 'RoleController@getAllRoles');

Route::post('account/create', 'UserController@store');
Route::put('account/update/{id}', 'UserController@update');

Route::delete('user/delete/{id}', 'UserController@delete');
Route::get('/search/user', 'UserController@search');
// =========MIDDLEWARE ROUTES========

Route::resource('role','RoleController');
Route::resource('permission', 'PermissionController');

// Route::group(['middleware' => ['role:admin']], function () {
//     Route::resource('role','RoleController');
// });

// Route::group(['middleware' => ['permission:Hamza']], function () {
//     Route::resource('permission', 'PermissionController');
// });