<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\UserController;
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

Route::prefix('/invitation')->group(function () {
    Route::get('/{user}', [InvitationController::class, 'show'])->name('invitation.show');
    Route::post('/{user}', [InvitationController::class, 'update'])->name('invitation.update');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/manage', [ManageController::class,'index'])
        ->name('manage.show');

    Route::prefix('/users')->group(function() {
        Route::livewire('/{user}', 'edit-user')
            ->name('user.show')
            ->middleware('can:view,user');

        Route::get('/', [UserController::class, 'users'])
            ->name('users.show');
    });

    Route::prefix('/restaurants')->group(function () {

        Route::get('/', [RestaurantController::class, 'index'])
            ->name('restaurants.show');

        Route::post('/', [RestaurantController::class ,'store'])
            ->name('restaurants.store')
            ->middleware('can:create,App\Models\Restaurant');

        Route::prefix('/{restaurant}')->group(function () {
            Route::livewire('/', 'edit-restaurant')
                ->name('restaurant.show')
                ->middleware('can:view,restaurant');

        Route::put('/', [RestaurantController::class, 'update'])
            ->name('restaurant.update')
            ->middleware('can:update,restaurant');

        Route::delete('/', [RestaurantController::class, 'destroy'])
            ->name('restaurant.destroy')
            ->middleware('can:delete,restaurant');

            Route::livewire('/{table}', 'edit-table')
                ->name('restaurant.table.show');
        });
    });

    Route::prefix('/reservations')->group(function () {

        Route::get('/', [ReservationsController::class, 'index'])
            ->name('reservations.show');

        Route::post('/', [ReservationsController::class, 'store'])
            ->name('reservations.store')
            ->middleware('can:create,App\Models\Reservation');

        Route::post('/search', [ReservationsController::class, 'search'])
            ->name('reservations.search');

        Route::get('/{reservation}', [ReservationsController::class, 'show'])
            ->name('reservation.show')
            ->middleware('can:view,reservation');

        Route::put('/{reservation}', [ReservationsController::class, 'update'])
            ->name('reservation.update')
            ->middleware('can:update,reservation');

        Route::delete('/{reservation}', [ReservationsController::class, 'destroy'])
            ->name('reservation.destroy')
            ->middleware('can:delete,reservation');
    });

    Route::prefix('/tables')->group(function () {
        Route::get('/', [TablesController::class, 'index'])
            ->name('tables.index');
    });
});
