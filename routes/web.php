<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/manage', 'ManageController@index')->name('manage');
Route::get('/reservations', 'ReservationsController@index')->name('reservations');
Route::get('/restaurant', 'RestaurantController@index')->name('restaurant');
Route::post('/restaurant', 'RestaurantController@store')->name('restaurant.store');
Route::patch('/restaurant/{restaurant}', 'RestaurantController@update')->name('restaurant.update');

// For AJAX calls
Route::get('/reservations/create', 'ReservationsController@create');

Route::get('/reservations/{reservation}', 'ReservationsController@show');
Route::post('/reservations', 'ReservationsController@store');

Route::put('/reservations/{reservation}', 'ReservationsController@update');
Route::delete('/reservations/{reservation}', 'ReservationsController@destroy');
