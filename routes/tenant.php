<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    
    // Rutas públicas del tenant (sin autenticación)
    Route::get('/', function () {
        $products = \App\Models\Product::where('active', true)->latest()->get();
        return view('tenant.catalog', compact('products'));
    })->name('tenant.catalog');

    Route::get('/product/{product}', function (\App\Models\Product $product) {
        return view('tenant.product-detail', compact('product'));
    })->name('tenant.product.detail');

    // Rutas de autenticación para el tenant
    Route::get('/login', function () {
        return view('tenant.auth.login');
    })->name('tenant.login');

    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('tenant.admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    });

    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('tenant.catalog');
    })->name('tenant.logout');

    // Rutas protegidas del administrador
    Route::middleware(['auth'])->prefix('admin')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('tenant.admin.dashboard');
        })->name('tenant.admin.dashboard');

        // CRUD de productos
        Route::get('/products', [ProductController::class, 'index'])->name('tenant.admin.products');
        Route::post('/products', [ProductController::class, 'store'])->name('tenant.admin.products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('tenant.admin.products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('tenant.admin.products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('tenant.admin.products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('tenant.admin.products.destroy');
        
    });
    
});

