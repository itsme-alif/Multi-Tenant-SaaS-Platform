<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        return response()->json(Tenant::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|unique:tenants,domain|max:255',
        ]);

        $tenant = Tenant::create([
            'id' => uniqid(),
            'name' => $request->name,
            'domain' => $request->domain,
        ]);

        return response()->json($tenant, 201);
    }
}

