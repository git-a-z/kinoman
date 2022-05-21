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

Route::get('/', [
    'uses' => 'App\Http\Controllers\HomeController@index',
    'as' => 'home'
]);

Route::get('/catalog', [
    'uses' => 'App\Http\Controllers\CatalogController@index',
    'as' => 'catalog'
]);

Route::get('/film/{film}', [
    'uses' => 'App\Http\Controllers\CatalogController@film',
    'as' => 'film'
]);

Route::get('/collections', [
    'uses' => 'App\Http\Controllers\CollectionController@index',
    'as' => 'collections'
]);

Route::get('/collection/{id}', [
    'uses' => 'App\Http\Controllers\CollectionController@collection',
    'as' => 'collection'
]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('/profile', [
    'uses' => 'App\Http\Controllers\ProfileController@index',
    'as' => 'profile'
]);

Route::get('/profile_list/{id}', [
    'uses' => 'App\Http\Controllers\ProfileController@list',
    'as' => 'profile_list'
]);

Route::post('/add_del_film_in_list', [
    'uses' => 'App\Http\Controllers\CatalogController@addDelFilmInList',
    'as' => 'add_del_film_in_list'
]);

Route::get('/search', [
    'uses' => 'App\Http\Controllers\SearchController@index',
    'as' => 'search'
]);

Route::post('/filter', [
    'uses' => 'App\Http\Controllers\SearchController@filter',
    'as' => 'filter'
]);

Route::post('/move_film_from_list_to_list', [
    'uses' => 'App\Http\Controllers\ProfileController@moveFilmFromListToList',
    'as' => 'move_film_from_list_to_list'
]);
