<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::latest()->get(); 
        return view('tenants', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa' => 'required|string|max:255|unique:tenants,id',
            'email' => 'required|email|max:255',
            'domain' => 'required|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|string|min:8',
        ]);

        $tenant = Tenant::create([
            'id' => $request->empresa,
            'email' => $request->email
        ]);

        $tenant->domains()->create(['domain' => $request->domain. '.localhost']);

        // Crear usuario administrador dentro del tenant
        $tenant->run(function () use ($request) {
            User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
            ]);
        });

        return redirect()->route('tenants')->with('success', 'Tenant y usuario administrador creados exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return response()->json([
            'id' => $tenant->id,
            'email' => $tenant->email,
            'domain' => $tenant->domains->first()->domain ?? 'Sin dominio',
            'created_at' => $tenant->created_at->format('d/m/Y H:i'),
            'updated_at' => $tenant->updated_at->format('d/m/Y H:i')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return response()->json([
            'id' => $tenant->id,
            'email' => $tenant->email,
            'domain' => str_replace('.localhost', '', $tenant->domains->first()->domain ?? '')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'domain' => 'required|string|max:255'
        ]);

        $tenant->update([
            'email' => $request->email
        ]);

        // Actualizar dominio
        if ($tenant->domains->first()) {
            $tenant->domains->first()->update(['domain' => $request->domain . '.localhost']);
        }

        return redirect()->route('tenants')->with('success', 'Tenant actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants')->with('success', 'Tenant eliminado exitosamente');
    }
}
