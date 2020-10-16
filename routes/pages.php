<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('about', [PageController::class, 'about']);
Route::get('contact', [PageController::class, 'contact']);
Route::get('staff', [PageController::class, 'staff']);
//Route::get('blog', 'PageController@blog', ['name' => Request::input('name', 'No name')]);
Route::view('blog', 'blog', ['name' => Request::input('name', 'No name')]);
