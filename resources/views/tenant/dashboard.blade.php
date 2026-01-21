@extends('tenant.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Dashboard - {{ strtoupper(tenant('id')) }}</h1>
        </div>
    </div>

    <div class="row">
        <!-- Card de Productos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-box-seam"></i> Productos
                    </h5>
                    <p class="card-text display-4">{{ \App\Models\Product::count() }}</p>
                    <a href="{{ route('tenant.products') }}" class="btn btn-light">Ver Inventario</a>
                </div>
            </div>
        </div>

        <!-- Card de Stock Total -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-stack"></i> Stock Total
                    </h5>
                    <p class="card-text display-4">{{ \App\Models\Product::sum('stock') }}</p>
                    <small>Unidades disponibles</small>
                </div>
            </div>
        </div>

        <!-- Card de Productos Activos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-check-circle"></i> Productos Activos
                    </h5>
                    <p class="card-text display-4">{{ \App\Models\Product::where('active', true)->count() }}</p>
                    <small>Productos disponibles para venta</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Bienvenido al Sistema de Inventario</h5>
                </div>
                <div class="card-body">
                    <p>Este es el panel principal de tu sistema de inventario. Desde aquí puedes:</p>
                    <ul>
                        <li>Ver estadísticas de tus productos</li>
                        <li>Gestionar tu inventario completo</li>
                        <li>Controlar el stock de tus productos</li>
                    </ul>
                    <p class="mb-0">
                        <strong>Tenant ID:</strong> {{ tenant('id') }}<br>
                        <strong>Base de datos:</strong> Aislada e independiente
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
