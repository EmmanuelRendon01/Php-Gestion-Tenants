@extends('tenant.public-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tenant.catalog') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <!-- Producto Detail -->
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="row">
                        @if($product->image)
                            <div class="col-md-5 mb-4">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                            </div>
                        @endif
                        
                        <div class="{{ $product->image ? 'col-md-7' : 'col-12' }} mb-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h1 class="mb-2">{{ $product->name }}</h1>
                                    <p class="text-muted">SKU: <code>{{ $product->sku }}</code></p>
                                </div>
                                @if($product->category)
                                    <span class="badge bg-secondary fs-6">{{ $product->category }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="{{ $product->image ? 'col-md-7' : 'col-md-8' }}">
                            @if($product->description)
                                <h5>Descripción</h5>
                                <p class="text-secondary">{{ $product->description }}</p>
                            @else
                                <p class="text-muted fst-italic">Este producto no tiene descripción.</p>
                            @endif
                        </div>

                        <div class="{{ $product->image ? 'col-md-5' : 'col-md-4' }}">
                            <div class="border rounded p-4 bg-light">
                                <h3 class="text-primary mb-3">${{ number_format($product->price, 2) }}</h3>
                                
                                <div class="mb-3">
                                    <strong>Disponibilidad:</strong><br>
                                    @if($product->stock > 0)
                                        <span class="badge bg-success fs-6">
                                            <i class="bi bi-check-circle"></i> En Stock ({{ $product->stock }} unidades)
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6">
                                            <i class="bi bi-x-circle"></i> Agotado
                                        </span>
                                    @endif
                                </div>

                                <hr>

                                <div class="text-muted small">
                                    <p class="mb-1"><strong>Agregado:</strong> {{ $product->created_at->format('d/m/Y') }}</p>
                                    @if($product->updated_at != $product->created_at)
                                        <p class="mb-0"><strong>Actualizado:</strong> {{ $product->updated_at->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('tenant.catalog') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al Catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
