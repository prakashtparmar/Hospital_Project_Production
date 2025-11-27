<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant; // Assuming Tenant model is located here
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Controller for managing hospital tenants (central application).
 * This typically involves creating a new tenant and assigning a domain.
 */
class HospitalController extends Controller
{
    /**
     * Display a listing of the hospitals (tenants).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Example: Retrieve and display a list of all tenants
        $tenants = Tenant::all();
        return view('central.hospitals.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new hospital tenant.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('central.hospitals.create');
    }

    /**
     * Store a newly created hospital tenant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            // Assumes a 'domains' table and validation to ensure the subdomain is unique
            'subdomain' => 'required|string|min:3|max:100|unique:domains,domain',
        ]);

        try {
            // Use a database transaction to ensure both tenant and domain creation succeed
            DB::beginTransaction();

            // 2. Create the Tenant record
            $tenant = Tenant::create([
                'id' => 'hospital_' . time(), // Generates a unique, time-based ID for the tenant
                'data' => [
                    'name' => $request->name,
                    'contact' => $request->contact
                ]
            ]);

            // 3. Create the Tenant's associated Domain
            $tenant->domains()->create([
                // Append the base domain to the requested subdomain
                'domain' => $request->subdomain . '.yourdomain.com'
            ]);

            // 4. Commit transaction
            DB::commit();

            // 5. Redirect with success message
            return redirect()
                ->route('central.hospitals.index')
                ->with('success', "Hospital '{$request->name}' created successfully!");

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            Log::error("Tenant creation failed: " . $e->getMessage(), ['exception' => $e]);

            // Redirect back with an error message
            return back()
                ->withInput()
                ->with('error', 'Failed to create the hospital tenant. Please try again.');
        }
    }

    /**
     * Remove the specified hospital tenant from storage.
     *
     * @param  string  $id The tenant ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            $tenantName = data_get($tenant->data, 'name', 'Unknown');
            // This assumes the Tenant model handles associated domains deletion
            $tenant->delete();

            return redirect()
                ->route('central.hospitals.index')
                ->with('success', "Hospital '{$tenantName}' and all associated domains were successfully deleted.");
        } catch (\Exception $e) {
            Log::error("Tenant deletion failed: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete the hospital tenant.');
        }
    }


    // Placeholder methods for completeness:
    // public function show(string $id) { /* ... */ }
    // public function edit(string $id) { /* ... */ }
    // public function update(Request $request, string $id) { /* ... */ }
}