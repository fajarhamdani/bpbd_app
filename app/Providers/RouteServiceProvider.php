<?php
// app/Providers/RouteServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Daftarkan alias untuk middleware

    }
}

