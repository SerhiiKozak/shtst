<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('widget-ticket', function (Request $request) {

            $phone = $request->input('phone');

            return [
                Limit::perDay(1)->by(
                    $phone ? 'phone:' . $phone : 'ip:' . $request->ip()
                ),

                Limit::perMinute(5)->by('ip:' . $request->ip()),
            ];
        });
    }
}
