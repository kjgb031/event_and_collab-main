<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

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
        DatabaseNotifications::trigger('components.notif');

        FilamentColor::register([
            'primary' => Color::hex('#841818'),
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,

            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }
}
