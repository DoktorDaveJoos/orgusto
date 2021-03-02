<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'show'])->name('home');

Route::post('/newsletter', [NewsletterController::class, 'subscribe']);

Route::get('/imprint', function() {
    return view('imprint');
})->name('imprint');

Route::get('/privacy', function() {
    return view('dataprotection');
})->name('privacy');

Route::prefix('/invitation')->group(function () {
    Route::get('/{user}', [InvitationController::class, 'show'])->name('invitation.show');
    Route::post('/{user}', [InvitationController::class, 'update'])->name('invitation.update');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/manage', [ManageController::class, 'index'])
        ->name('manage.show');

    Route::prefix('/users')->group(function () {
        Route::get('/{user}', [UserController::class, 'show'])
            ->name('user.show')
            ->middleware('can:view,user');

        Route::post('/user/subscribe', function (Request $request) {
            $request->user()->newSubscription(
                'default', 'price_premium'
            )->create($request->paymentMethodId);

            // TODO
        });

        Route::get('/', [UserController::class, 'users'])
            ->name('users.show');
    });

    Route::prefix('/restaurants')->group(function () {

        Route::get('/', [RestaurantController::class, 'index'])
            ->name('restaurants.show');

        Route::post('/', [RestaurantController::class, 'store'])
            ->name('restaurants.store')
            ->middleware('can:create,App\Models\Restaurant');

        Route::prefix('/{restaurant}')->group(function () {
            Route::get('/', [RestaurantController::class, 'show'])
                ->name('restaurant.show')
                ->middleware('can:view,restaurant');

            Route::put('/', [RestaurantController::class, 'update'])
                ->name('restaurant.update')
                ->middleware('can:update,restaurant');

            Route::delete('/', [RestaurantController::class, 'destroy'])
                ->name('restaurant.destroy')
                ->middleware('can:delete,restaurant');

            Route::post('/delete', [RestaurantController::class, 'formDestroy'])
                ->name('restaurant.formDestroy')
                ->middleware('can:delete,restaurant');

            Route::get('/{table}', [RestaurantController::class, 'showTable'])
                ->name('restaurant.table.show');
        });
    });

    Route::prefix('/reservations')->group(function () {

        Route::get('/', [ReservationsController::class, 'index'])
            ->name('reservations.show');

        Route::get('/scoped', [ReservationsController::class, 'scoped'])
            ->name('reservations.scoped');

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

        Route::put('/{reservation}/fulfilled', [ReservationsController::class, 'done'])
            ->name('reservation.done')
            ->middleware('can:update,reservation');

    });

    Route::prefix('/tables')->group(function () {
        Route::get('/', [TablesController::class, 'index'])
            ->name('tables.index');

        Route::get('/all', [TablesController::class, 'allTables'])
            ->name('tables.all');
    });
});
