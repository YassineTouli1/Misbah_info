<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

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
        // Be defensive during composer package:discover and early boot where DB may not be ready
        try {
            // Attempt to get connection without forcing a query
            $driver = DB::getDriverName();

            // Enable foreign keys for SQLite only if database file exists
            if ($driver === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                if (is_string($sqlitePath) && $sqlitePath !== ':memory:' && file_exists($sqlitePath)) {
                    DB::statement('PRAGMA foreign_keys=ON;');
                }
            }
        } catch (\Throwable $e) {
            // Swallow DB errors at boot time (build/package discovery)
        }

        // Share settings with all views, but do not fail if DB isn't ready
        View::composer('*', function ($view) {
            $settings = null;
            try {
                $settings = Setting::query()->first();
            } catch (\Throwable $e) {
                $settings = null;
            }
            $view->with('settings', $settings);
        });
    }
}
