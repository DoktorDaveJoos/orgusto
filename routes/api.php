<?php

use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [UserController::class, 'show'])
        ->name('users.show');

    Route::middleware('verified')->group(function () {

        Route::prefix('/restaurants')->group(function () {

            Route::get('/', [RestaurantController::class, 'index'])
                ->name('restaurants.show');

            Route::post('/', [RestaurantController::class, 'store'])
                ->name('restaurants.store')
                ->middleware('can:create,App\Models\Restaurant');

            Route::get('/{restaurant}', [RestaurantController::class, 'show'])
                ->name('restaurant.show')
                ->middleware('can:view,restaurant');

            Route::put('/{restaurant}', [RestaurantController::class, 'update'])
                ->name('restaurant.update')
                ->middleware('can:update,restaurant');

            Route::delete('/{restaurant}', [RestaurantController::class, 'destroy'])
                ->name('restaurant.destroy')
                ->middleware('can:delete,restaurant');

        });

        Route::middleware('subscribed')->group(function () {

            Route::prefix('/reservations')->group(function() {

                Route::get('/', [ReservationsController::class, 'index'])
                    ->name('reservations.show');

                Route::post('/', [ReservationsController::class, 'store'])
                    ->name('reservations.store')
                    ->middleware('can:create,App\Models\Reservation');

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

            Route::prefix('/tables')->group(function() {

                Route::get('/', [TablesController::class, 'index'])
                    ->name('tables.index')
                    ->middleware('can:view,App\Models\Table');

                Route::post('/', [TablesController::class, 'store'])
                    ->name('tables.store')
                    ->middleware('can:create,App\Models\Table');

                Route::get('/{table}', [TablesController::class, 'show'])
                    ->name('table.show')
                    ->middleware('can:view,table');

                Route::put('/{table}', [TablesController::class, 'update'])
                    ->name('table.update')
                    ->middleware('can:view,table');

                Route::delete('/{table}', [TablesController::class, 'destroy'])
                    ->name('table.destroy')
                    ->middleware('can:view,table');

            });
        });
    });
});






