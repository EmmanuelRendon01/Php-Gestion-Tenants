@extends('tenant.layout')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Gestión de Productos</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    <i class="bi bi-plus-circle"></i> Nuevo Producto
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>SKU</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td><code>{{ $product->sku }}</code></td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            @if($product->category)
                                                <span class="badge bg-secondary">{{ $product->category }}</span>
                                            @else
                                                <span class="text-muted">Sin categoría</span>
                                            @endif
                                        </td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $product->stock }} unidades
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->active)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-info" onclick="viewProduct({{ $product->id }})" title="Ver">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning" onclick="editProduct({{ $product->id }})" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger" onclick="deleteProduct({{ $product->id }})" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-0">No hay productos registrados.</p>
                                            <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#createProductModal">
                                                Crear primer producto
                                            </button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Producto -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('tenant.products.store') }}" method="POST">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Registrar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre del Producto *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU *</label>
                            <input type="text" class="form-control" id="sku" name="sku" required placeholder="PROD-001">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Precio *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stock *</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" required value="0">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="category" name="category" placeholder="Electrónica">
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" checked>
                                <label class="form-check-label" for="active">
                                    Producto activo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver Producto -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <p class="form-control-plaintext" id="view-product-name"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">SKU</label>
                        <p class="form-control-plaintext"><code id="view-product-sku"></code></p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <p class="form-control-plaintext" id="view-product-description"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Precio</label>
                        <p class="form-control-plaintext">$<span id="view-product-price"></span></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stock</label>
                        <p class="form-control-plaintext" id="view-product-stock"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Categoría</label>
                        <p class="form-control-plaintext" id="view-product-category"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Estado</label>
                        <p class="form-control-plaintext" id="view-product-active"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Creado</label>
                        <p class="form-control-plaintext" id="view-product-created"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Actualizado</label>
                        <p class="form-control-plaintext" id="view-product-updated"></p>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editProductForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit-name" class="form-label">Nombre del Producto *</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit-sku" class="form-label">SKU *</label>
                            <input type="text" class="form-control" id="edit-sku" name="sku" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="edit-description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit-description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="edit-price" class="form-label">Precio *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="edit-price" name="price" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="edit-stock" class="form-label">Stock *</label>
                            <input type="number" class="form-control" id="edit-stock" name="stock" min="0" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="edit-category" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="edit-category" name="category">
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit-active" name="active" value="1">
                                <label class="form-check-label" for="edit-active">
                                    Producto activo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Producto -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteProductForm" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProductModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar el producto <strong id="delete-product-name"></strong>?</p>
                    <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
