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
                    <th scope="col">Tenant</th>
                    <th scope="col">Dominio</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->domains->first()->domain ?? 'Sin dominio' }}</td>
                        <td>Otto</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</x-app-layout>