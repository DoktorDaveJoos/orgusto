<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('filterByTable', function ($array, $tableNumber) {
            $filterByTable = function ($arrayToFilter, $number) {
                if (in_array($number, $arrayToFilter->tables)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            };

            return array_filter($array, $filterByTable, $tableNumber);
        });

        Blade::component('components.info-card', 'infocard');

        Blade::component('components.table', 'table');
        Blade::component('components.table-head', 'tablehead');
        Blade::component('components.table-cell', 'tablecell');

        Blade::component('components.notification', 'notification');

        Blade::component('components.form-input', 'forminput');
    }
}
