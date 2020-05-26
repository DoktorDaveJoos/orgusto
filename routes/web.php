<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationsController;
use App\Restaurant;
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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();
Route::middleware(['auth'])->group(function () {

    Route::get('/manage', 'ManageController@index')->name('manage.show');

    Route::prefix('/restaurants')->group(function () {
        Route::get('/', 'RestaurantController@index')->name('restaurants.show');
        Route::post('/', 'RestaurantController@store')->name('restaurants.store');

        Route::prefix('/{restaurant}')->group(function () {
            Route::livewire('/', 'edit-restaurant')->name('restaurant.show');

            Route::put('/', 'RestaurantController@update')->name('restaurant.update');
            Route::delete('/', 'RestaurantController@destroy')->name('restaurant.destroy');

            Route::livewire('/{table}', 'edit-table')->name('restaurant.table.show');
        });
    });

    Route::prefix('/reservations')->group(function () {

        Route::get('/', 'ReservationsController@index')->name('reservations.show');
        Route::post('/', 'ReservationsController@store')->name('reservations.store');

        Route::put('/{reservation}', 'ReservationsController@update')->name('reservation.update');
        Route::delete('/{reservation}', 'ReservationsController@destroy')->name('reservation.destroy');
    });
});
