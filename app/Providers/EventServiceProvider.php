<?php

namespace App\Providers;

use App\Listeners\MigrateTenantDatabase;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Events\TenantCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        TenantCreated::class => [
            MigrateTenantDatabase::class,
        ],
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
