<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Restaurant' => 'App\Policies\RestaurantPolicy',
        'App\User' => 'App\Policies\UserPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->greeting('Willkommen bei Orgusto!')
                ->salutation('Vielen lieben Dank, dein Orgusto Team :-)')
                ->subject('Email Adresse bestätigen')
                ->line('Klicken Sie auf die Schaltfläche unten, um Ihre E-Mail-Adresse zu bestätigen.')
                ->action('E-Mail Adresse bestätigen', $url);
        });


    }
}
