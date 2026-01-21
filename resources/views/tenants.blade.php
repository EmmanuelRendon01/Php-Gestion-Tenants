<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tenants') }}
            </h2>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTenantModal">
                Crear Nuevo Tenant
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant (ID)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dominio</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($tenants as $tenant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $tenant->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tenant->domains->first()->domain ?? 'Sin dominio asignado' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->updated_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" class="btn btn-info btn-sm me-1" onclick="viewTenant('{{ $tenant->id }}')">
                                        Ver
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm me-1" onclick="editTenant('{{ $tenant->id }}')">
                                        Editar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteTenant('{{ $tenant->id }}')">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay tenants registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Crear Tenant -->
    <div class="modal fade" id="createTenantModal" tabindex="-1" aria-labelledby="createTenantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('tenants.store') }}" method="POST">
                    @csrf
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTenantModalLabel">Registrar Nuevo Tenant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <h6 class="mb-3 text-primary">Información del Tenant</h6>
                        
                        <div class="mb-3">
                            <label for="empresa" class="form-label">Identificador (ID)</label>
                            <input type="text" class="form-control" id="empresa" name="empresa" required placeholder="cliente_01">
                            <div class="form-text">ID único del tenant</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico del Tenant</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="contacto@empresa.com">
                        </div>

                        <div class="mb-3">
                            <label for="domain" class="form-label">Dominio</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="domain" name="domain" required placeholder="mi-empresa">
                                <span class="input-group-text">.localhost</span>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <h6 class="mb-3 text-primary">Usuario Administrador</h6>
                        
                        <div class="mb-3">
                            <label for="admin_name" class="form-label">Nombre del Administrador</label>
                            <input type="text" class="form-control" id="admin_name" name="admin_name" required placeholder="Juan Pérez">
                        </div>

                        <div class="mb-3">
                            <label for="admin_email" class="form-label">Email del Administrador</label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email" required placeholder="admin@empresa.com">
                        </div>

                        <div class="mb-3">
                            <label for="admin_password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="admin_password" name="admin_password" required minlength="8" placeholder="Mínimo 8 caracteres">
                            <div class="form-text">Este será el usuario para acceder al panel de administración</div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Tenant -->
    <div class="modal fade" id="viewTenantModal" tabindex="-1" aria-labelledby="viewTenantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTenantModalLabel">Detalles del Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Identificador (ID)</label>
                        <p class="form-control-plaintext" id="view-tenant-id"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Correo Electrónico</label>
                        <p class="form-control-plaintext" id="view-tenant-email"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Dominio</label>
                        <p class="form-control-plaintext" id="view-tenant-domain"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha de Creación</label>
                        <p class="form-control-plaintext" id="view-tenant-created"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Última Actualización</label>
                        <p class="form-control-plaintext" id="view-tenant-updated"></p>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Tenant -->
    <div class="modal fade" id="editTenantModal" tabindex="-1" aria-labelledby="editTenantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editTenantForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTenantModalLabel">Editar Tenant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-tenant-id" class="form-label">Identificador (ID)</label>
                            <input type="text" class="form-control" id="edit-tenant-id" disabled>
                            <div class="form-text">El ID no puede ser modificado</div>
                        </div>

                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-domain" class="form-label">Dominio</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="edit-domain" name="domain" required>
                                <span class="input-group-text">.localhost</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Tenant -->
    <div class="modal fade" id="deleteTenantModal" tabindex="-1" aria-labelledby="deleteTenantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteTenantForm" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteTenantModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar el tenant <strong id="delete-tenant-id"></strong>?</p>
                        <p class="text-danger">Esta acción no se puede deshacer.</p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>