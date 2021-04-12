<?php

namespace App\Providers;

use App\User;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Spark\Plan;
use Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    Spark::ignoreMigrations();

    // ...
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Spark::billable(Restaurant::class)->resolve(function (Request $request) {
      return $request->user()->selected;
    });

    Spark::billable(Restaurant::class)->authorize(function (Restaurant $billable, Request $request) {
      return $request->user() && $request->user() == $billable->owner;
    });

    Spark::billable(Restaurant::class)->checkPlanEligibility(function (Restaurant $billable, Plan $plan) {
      if ($billable->tables->count() > 100 && $plan->name == 'Standard') {
        throw ValidationException::withMessages([
          'plan' => 'Leider hast du die maximale Anzahl an Tischen für den Plan: ' . $plan->name . ' erreicht.',
        ]);
      }
    });
  }
}
