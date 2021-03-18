<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
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
                    return true;
                } else {
                    return false;
                }
            };

            return array_filter($array, $filterByTable, $tableNumber);
        });

        Blade::aliasComponent('components.info-card', 'infocard');

        Blade::aliasComponent('components.table', 'table');
        Blade::aliasComponent('components.table-head', 'tablehead');
        Blade::aliasComponent('components.table-cell', 'tablecell');

        Blade::aliasComponent('components.notification', 'notification');

        Blade::aliasComponent('components.form-input', 'forminput');

        Blade::aliasComponent('components.modal', 'modal');
    }
}
