<?php

use App\Events\NewAlbumCreated;
use App\Mail\TestEmail;
use App\Mail\TestMd;
use App\Models\Album;
use App\Models\Photo;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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


Route::get('welcome/{name?}/{lastname?}/{age?}', 'WelcomeController@welcome'
)->where([
    'name' => '[a-zA-Z]+',
    'lastname' => '[a-zA-Z]+',
    'age' => '[0-9]{1,3}+'
]);

Route::get('/users', function () {
    return User::all();
});


Route::middleware(['auth'])->prefix('dashboard')->group(function () {

    /*
    |---------------------------------------------------
    | ALBUMS   
    |---------------------------------------------------
    |
    | Routes for Resource Controller AlbumsController.php
    |
    */
    Route::get('/', 'AlbumsController@index')->name('albums');
    Route::get('/albums', 'AlbumsController@index')->name('albums');
    Route::get('/albums/{album}', 'AlbumsController@show')->where('album', '[0-9]+')->middleware('can:view,album');
    Route::get('/albums/{id}/edit', 'AlbumsController@edit')->name('album.edit')->where('id', '[0-9]+');
    Route::delete('/albums/{album}', 'AlbumsController@delete')->name('album.delete')->where('id', '[0-9]+');
    Route::patch('/albums/{id}', 'AlbumsController@store')->name('album.store')->where('id', '[0-9]+');
    Route::get('/albums/create', 'AlbumsController@create')->name('album.create');
    Route::post('/albums', 'AlbumsController@save')->name('album.save');

    Route::get('/albums/{album}/images', 'AlbumsController@getImages')->name('album.getimages')
        ->where('id', '[0-9]+');

    /* prova route */
    Route::get('/usersnoalbums', function () {
        $usernoalbum =  DB::table('users as u')
            ->leftJoin('albums as a', 'u.id', '=', 'a.user_id')
            ->select('name', 'email', 'u.id', 'album_name')
            ->whereNull('album_name')
            ->get();
        return $usernoalbum;
    });

    /*
    |---------------------------------------------------
    | IMAGES   
    |---------------------------------------------------
    |
    | Routes for Resource Controller PhotosController.php
    |
    */
    Route::resource('photos', 'PhotosController');


    /*
        |---------------------------------------------------
        | CATEGORIES   
        |---------------------------------------------------
        |
        | Routes for Categories
        |
    */
    Route::resource('/categories', 'AlbumCategoryController');
});


/*
    |---------------------------------------------------
    | AUTH   
    |---------------------------------------------------
    |
    | Routes for Resource Controllers Auth
    |
    */

Auth::routes();


/*
    |---------------------------------------------------
    | GALLERY   
    |---------------------------------------------------
    |
    | Routes for GALLERY
    |
*/

Route::group(['prefix' => 'gallery'], function () {
    Route::get('/', 'GalleryController@index')->name('gallery.albums');
    Route::get('albums', 'GalleryController@index')->name('gallery.albums');
    Route::get('album/{album}/images', 'GalleryController@showAlbumImages')->name('gallery.album.images');
    Route::get('albums/category/{category}', 'GalleryController@showAlbumsByCategory')->name('gallery.album.category');
});

/*
    |---------------------------------------------------
    | HOME   
    |---------------------------------------------------
    |
    | Routes for HOME punta a gallery che è visibile per tutti gli users
    |
*/
Route::get('/', 'GalleryController@index');
Route::get('/home', 'GalleryController@index')->name('home');

/*
    |---------------------------------------------------
    | EMAIL / EVENT&LISTENER
    |---------------------------------------------------
    |
    | Routes for testing the email send & event-lister
    |
*/

//The Email Verification Notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

//The Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('albums');
})->middleware(['auth', 'signed'])->name('verification.verify');

//Resending The Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

