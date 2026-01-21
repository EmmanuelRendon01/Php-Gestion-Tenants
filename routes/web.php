<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;

/*
|--------------------------------------------------------------------------
| Rutas Centrales
|--------------------------------------------------------------------------
|
| Estas rutas solo son accesibles desde tus dominios principales
| (definidos en config/tenancy.php). No funcionarán en los
| subdominios de los inquilinos (tenants).
|
*/

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        
        // 1. Ruta de bienvenida (Landing Page)
        Route::get('/', function () {
            return view('welcome');
        });

        // Rutas de autenticación de Fortify (incluye login, register, etc.)
        // Estas rutas son registradas automáticamente por Fortify
        
        // 2. Rutas protegidas por autenticación (Jetstream / Dashboard Central)
        Route::middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
        ])->group(function () {

            Route::get('/dashboard', function () {
                return view('dashboard');
            })->name('dashboard');

            Route::get('/tenants', [TenantController::class, 'index'])->name('tenants');

            Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
            
            Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
            
            Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
            
            Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
            
            Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');

        });

    });
}