@extends('tenant.public-layout')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-primary text-white rounded p-5 text-center">
                <h1 class="display-4 fw-bold mb-3">Bienvenido a {{ strtoupper(tenant('id')) }}</h1>
                <p class="lead mb-0">Descubre nuestros productos y encuentra lo que necesitas</p>
            </div>
        </div>
    </div>

    <!-- Productos -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4">Nuestros Productos</h2>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $product->name }}</h5>
                            @if($product->category)
                                <span class="badge bg-secondary">{{ $product->category }}</span>
                            @endif
                        </div>
                        
                        <p class="text-muted small mb-2">SKU: {{ $product->sku }}</p>
                        
                        @if($product->description)
                            <p class="card-text text-secondary">
                                {{ Str::limit($product->description, 100) }}
                            </p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <h4 class="text-primary mb-0">${{ number_format($product->price, 2) }}</h4>
                            </div>
                            <div>
                                @if($product->stock > 0)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Disponible
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Agotado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="{{ route('tenant.product.detail', $product) }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-eye"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                    <h4>No hay productos disponibles en este momento</h4>
                    <p class="mb-0">Vuelve pronto para ver nuestras novedades.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
