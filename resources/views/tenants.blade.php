<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenants') }}
        </h2>
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