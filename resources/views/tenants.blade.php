<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenants') }}
        </h2>

        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createTenantModal">
            Crear Nuevo Tenant
        </button>


    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Tenant (ID)</th>
                        <th scope="col">Dominio</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->id }}</td>
                            <td>
                                {{ $tenant->domains->first()->domain ?? 'Sin dominio asignado' }}
                            </td>
                            <td>{{ $tenant->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $tenant->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        {{-- Esto se mostrará si NO hay registros --}}
                        <tr>
                            <td colspan="4" class="text-center">
                                No hay tenants registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </div>

    
</x-app-layout>

<!-- Modal -->
<div class="modal fade" id="createTenantModal" tabindex="-1" aria-labelledby="createTenantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- El formulario envuelve el contenido del modal -->
            <form action="{{ route('tenants.store') }}" method="POST">
                @csrf 

                <div class="modal-header">
                    <h5 class="modal-title" id="createTenantModalLabel">Registrar Nuevo Inquilino</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    
                    <!-- Campo 1: Identificador de la Empresa -->
                    <!-- Tu controlador espera: $request->empresa -->
                    <div class="mb-3">
                        <label for="empresa" class="form-label">Identificador (ID)</label>
                        <input type="text" class="form-control" id="empresa" name="empresa" required placeholder="Ej: cliente_01">
                        <div class="form-text">Este será el ID único del tenant.</div>
                    </div>

                    <!-- Campo 2: Email -->
                    <!-- Tu controlador espera: $request->email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="admin@empresa.com">
                    </div>

                    <!-- Campo 3: Dominio -->
                    <!-- Tu controlador espera: $request->domain -->
                    <div class="mb-3">
                        <label for="domain" class="form-label">Dominio</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="domain" name="domain" required placeholder="mi-empresa">
                            <!-- Visualmente le mostramos al usuario que se agrega .localhost -->
                            <span class="input-group-text">.localhost</span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Tenant</button>
                </div>

            </form>
        </div>
    </div>
</div>