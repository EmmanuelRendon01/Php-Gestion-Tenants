<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    Route::get('/', function () {
        return view('tenant.dashboard');
    })->name('tenant.dashboard');

    // Rutas de productos (inventario)
    Route::get('/products', [ProductController::class, 'index'])->name('tenant.products');
    Route::post('/products', [ProductController::class, 'store'])->name('tenant.products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('tenant.products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('tenant.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('tenant.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('tenant.products.destroy');
    
});

