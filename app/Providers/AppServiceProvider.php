<?php

namespace App\Providers;

use App\Support\DatabaseTablePreferencesStore;
use Dennenboom\VerdantUI\Contracts\DynamicTablePreferencesStore;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DynamicTablePreferencesStore::class, DatabaseTablePreferencesStore::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
