<?php

use App\Restaurant;
use Spark\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Spark Path
    |--------------------------------------------------------------------------
    |
    | This configuration option determines the URI at which the Spark billing
    | portal is available. You are free to change this URI to a value that
    | you prefer. You shall link to this location from your application.
    |
    */

    'path' => 'billing',

    /*
    |--------------------------------------------------------------------------
    | Spark Middleware
    |--------------------------------------------------------------------------
    |
    | These are the middleware that requests to the Spark billing portal must
    | pass through before being accepted. Typically, the default list that
    | is defined below should be suitable for most Laravel applications.
    |
    */

    'middleware' => ['web', 'auth'],

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to customize the branding of the
    | billing portal, including the primary color and the logo that will
    | be displayed within the billing portal. This logo value must be
    | the absolute path to an SVG logo within the local filesystem.
    |
    */

     'brand' =>  [
         'logo' => realpath(__DIR__.'/../public/orgusto-logo-small.svg'),
         'color' => 'bg-indigo-600',
     ],

    /*
    |--------------------------------------------------------------------------
    | Proration Behavior
    |--------------------------------------------------------------------------
    |
    | This value determines if charges are prorated when making adjustments
    | to a plan such as incrementing or decrementing the quantity of the
    | plan. This also determines proration behavior if changing plans.
    |
    */

    'prorates' => true,

    /*
    |--------------------------------------------------------------------------
    | Spark Billables
    |--------------------------------------------------------------------------
    |
    | Below you may define billable entities supported by your Spark driven
    | application. You are free to have multiple billable entities which
    | can each define multiple subscription plans available for users.
    |
    | In addition to defining your billable entity, you may also define its
    | plans and the plan's features, including a short description of it
    | as well as a "bullet point" listing of its distinctive features.
    |
    */

    'billables' => [

        'restaurant' => [
            'model' => Restaurant::class,
            'trial_days' => 7,
            'plans' => [
                [
                    'name' => 'Standard',
                    'short_description' => 'Eine Woche kostenlos. Sollten wir Dich nicht überzeugen können, kannst du jederzeit kündigen.',
                    'monthly_id' => env('SPARK_STANDARD_MONTHLY_PLAN', 'price_1IRZSPLMmvjDxaukmZ3sT9bz'),
                    'yearly_id' => env('SPARK_STANDARD_YEARLY_PLAN', 'price_1IRZTxLMmvjDxaukGIAlGjTD'),
                    'yearly_incentive' => 'Spare 10%',
                    'features' => [
                        'Unbegrenzte Reservierungen',
                        'Rollen & Nutzerrechte',
                        'Bis zu 100 Tische.',
                        'Support via Telefon & Email',
                    ],
                    'archived' => false,
                ],
            ],
        ],

    ],

    'features' => [
        Features::euVatCollection(['home-country' => 'DE']),
    ],
];
