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

use Illuminate\Support\Facades\Auth;


Route::get('/ss', function () {
    return view('welcome');
});

Route::get('/login', 'UserController@showLogin')->name('login');
Route::post('/login', 'UserController@login');
// Route::get('/logout', function () {
//     session()->flush();
//     Auth::logout();
//     return redirect('login');
// });

Route::get('/register', 'userController@showRegister');
Route::post('/register', 'UserController@storeRegistration');


Route::get('/logout', 'UserController@logout');

// Route::get('/', 'indexController@indexAction');
Route::get('/', 'indexController@listItems');

Route::get('/addItems', 'indexController@addAction')->middleware('can:isAdmin');
Route::post('/addItems/create', 'indexController@itemStore');

Route::get('/delete/{id}','indexController@deleteAction');

Route::get('/edit/{id}', 'indexController@editAction');
Route::post('/updateItem/{id}', 'indexController@update');

Route::get('/details/{id}', 'detailController@showAction');
Route::post('/addComment/{id}', 'detailController@addComment');


// Route::get('/addCarouselImages/{id}', 'imageController@showCarouselForm');
// Route::post('/addCarouselImages', 'imageController@addCarouselImage');

Route::post('/addImage/{id}', 'imageController@addMainImage');
Route::post('/updateMainImage/{id}', 'imageController@updateMainImage');
Route::post('/addCarouselImages/{id}', 'imageController@addCarouselImage');

// Route::post('/editImage/{id}', 'imageController@editImage');

//Google Oauth
Route::get('/redirect', 'GoogleAuthController@redirect');
Route::get('/callback', 'GoogleAuthController@callback');
