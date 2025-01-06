<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\IsSuperAdmin; // Pastikan middleware Anda diimpor

class Kernel extends HttpKernel
{
    /**
     * Register the application's middleware groups and individual middleware.
     */
    protected function registerMiddleware(): void
    {
        parent::registerMiddleware();

        // Daftar middleware untuk rute
        $this->routeMiddleware([
            'isSuperAdmin' => IsSuperAdmin::class, // Middleware baru Anda
        ]);
    }
}
