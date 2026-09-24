<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Ticket;
use App\Policies\OrderPolicy;
use App\Policies\TicketPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

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
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Ticket::class, TicketPolicy::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(6)->by(
                Str::transliterate(Str::lower($request->string('email')).'|'.$request->ip())
            );
        });

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        Password::defaults(function () {
            return Password::min(8)->letters()->numbers();
        });
    }
}
