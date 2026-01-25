<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Livewire components
        Livewire::component('profile.two-factor-authentication-form', \App\Livewire\Profile\TwoFactorAuthenticationForm::class);
        Livewire::component('profile.update-profile-information-form', \App\Livewire\Profile\UpdateProfileInformationForm::class);
        Livewire::component('profile.update-password-form', \App\Livewire\Profile\UpdatePasswordForm::class);
        Livewire::component('profile.logout-other-browser-sessions-form', \App\Livewire\Profile\LogoutOtherBrowserSessionsForm::class);
        Livewire::component('profile.delete-user-form', \App\Livewire\Profile\DeleteUserForm::class);
    }
}
