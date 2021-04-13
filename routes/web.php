<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/imprint', function () {
    return view('imprint');
})->name('imprint');

Route::get('/privacy', function () {
    return view('dataprotection');
})->name('privacy');

Route::post('/newsletter', [NewsletterController::class, 'subscribe'])
    ->name('newsletter');

Route::prefix('/invitation')->group(function () {

    Route::get('/{user}', [InvitationController::class, 'show'])
        ->name('invitation.show');

    Route::post('/{user}', [InvitationController::class, 'update'])
        ->name('invitation.update');

});

Route::middleware(['auth'])->group(function () {

    /**
     * Single Page Application
     */
    Route::get('/app/{any?}', [SpaController::class, 'index'])->name('spa');

    Route::prefix('/email')->group(function () {

        Route::get('/verify', function () {
            return view('auth.verify');
        })->name('verification.notice');

        Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect()->route('spa');
        })
            ->middleware(['signed'])
            ->name('verification.verify');

        Route::post('/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('message', 'Verification link sent!');
        })
            ->middleware('throttle:6,1')
            ->name('verification.send');

    });
});
