<?php

use Illuminate\Support\Facades\Route;

Route::resource(
    'users',
    'Admin\AdminUsersController',
    ['names' =>
    ['index' => 'user-list']]
);
Route::get('getUsers', 'Admin\AdminUsersController@getUsers')->name('admin.getUsers');
Route::patch('/users/{user}/restore', 'Admin\AdminUsersController@restore')->name('users.restore');
Route::view('/', 'templates.admin')->name('admin');
Route::get('/dashboard', function () {
    return 'Admin dashboard ';
});
