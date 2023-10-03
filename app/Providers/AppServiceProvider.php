<?php

namespace App\Providers;

use App\Services\FlashService;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FlashService::class, function ($app) {
            return new FlashService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Blade::directive('canEdit', function ($note) {
            return "<?php if ({$note}->user_id == auth()->id() || auth()->user()->is_admin == 1) : ?>";
        });

        Blade::directive('endcanEdit', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('canDestroy', function ($note) {
            return "<?php if ({$note}->user_id == auth()->id() || auth()->user()->is_admin == 1) : ?>";
        });

        Blade::directive('endcanDestroy', function () {
            return "<?php endif; ?>";
        });
    }
}
