<?php

use Illuminate\Support\Facades\Auth;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [
    'uses' => 'App\Http\Controllers\HomeController@index',
    'as' => 'home'
]);

Route::get('/catalog', [
    'uses' => 'App\Http\Controllers\CatalogController@index',
    'as' => 'catalog'
]);

Route::get('/collections', [
    'uses' => 'App\Http\Controllers\CollectionController@index',
    'as' => 'collections'
]);

//Route::get('/film/{id}', [
//    'uses' => 'App\Http\Controllers\CatalogController@film',
//    'as' => 'film'
//]);

Route::get('/film/{filmInfoView}', [
    'uses' => 'App\Http\Controllers\CatalogController@film',
    'as' => 'film'
]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('/profile', [
    'uses' => 'App\Http\Controllers\ProfileController@index',
    'as' => 'profile'
]);


