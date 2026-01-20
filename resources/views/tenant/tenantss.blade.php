<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenants') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('tenant.store') }}">
                @csrf

                <x-input type="text" name="empresa" class="block mt-1 w-50" placeholder="ejemplo: miempresa" />
                
                <x-input type="text" name="email" class="block mt-1 w-50" placeholder="ejemplo: dueño@correo.com" />

                <x-input type="text" name="domain" class="block mt-1 w-50" placeholder="ejemplo: midominio" />

                <x-button class="mt-5">
                    {{ __('Crear Tenant') }}
                </x-button>
                
            </form>
        </div>
    </div>
</x-app-layout>