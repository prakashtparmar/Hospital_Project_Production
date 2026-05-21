<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\TenantDomain;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Tenant::with('domains')->get();
        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('admin.hospitals.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'contact' => 'nullable',
    //         'subdomain' => 'required|alpha_dash|min:3|max:100',
    //     ]);

    //     $base = config('app.base_domain', 'main.localhost');
    //     $domain = $request->subdomain . '.' . $base;

    //     // Check domain availability
    //     if (TenantDomain::where('domain', $domain)->exists()) {
    //         return back()->withErrors(['subdomain' => 'Subdomain already exists']);
    //     }

    //     // Unique Tenant ID
    //     $id = time();
        
    //     // Create tenant
    //     // $tenant = Tenant::create([
    //     //     'id' => $id,
    //     //     'data' => [
    //     //         'name' => $request->name,
    //     //         'contact' => $request->contact,
    //     //     ],
    //     //     'tenancy_db_name' => $request->tenant,
    //     // ]);
    //     $tenant = Tenant::create([
    //         'id' => $id,
    //         'data' => [
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //         ],
    //         'tenancy_db_name' => 'tenant_' . $id,  // save database name
    //     ]);
    //     // dd($tenant);
    //     $data = json_decode($tenant->data, true);
    //     if(!empty($data['tenancy_db_name'])){
    //         $dbName = $data['tenancy_db_name'];
    //     }

    //     // Assign domain
    //     $tenant->domains()->create([
    //         'domain' => $domain,
    //     ]);

    //     // -------------------------
    //     // 🔥 Critical: Initialize tenancy
    //     // -------------------------
    //     tenancy()->initialize($tenant);


    //     $tenantConnection = config('database.connections.tenant');
    //     $tenantConnection['database'] = $dbName;
    //     config(['database.connections.tenant' => $tenantConnection]);
    //     DB::purge('tenant');
    //     DB::reconnect('tenant');


    //     // -------------------------
    //     // 🔥 Run tenant migrations
    //     // -------------------------
    //     // \Artisan::call('tenants:migrate', [
    //     //     '--tenants' => [$tenant->id],
    //     //     '--force' => true,
    //     // ]);

    //     Artisan::call('migrate', [
    //         '--database' => 'tenant',
    //         '--path' => 'database/migrations/tenant',
    //         '--force' => true,
    //     ]);

    //     tenancy()->end(); // End tenant context

    //     return redirect()->route('admin.hospitals.index')
    //         ->with('success', 'Hospital created successfully!');
    // }


    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'contact'   => 'nullable',
            'subdomain' => 'required|alpha_dash|min:3|max:100',
        ]);

        $base = config('app.base_domain', 'main.localhost');
        $domain = $request->subdomain . '.' . $base;

        // Check if domain already exists
        if (TenantDomain::where('domain', $domain)->exists()) {
            return back()->withErrors(['subdomain' => 'Subdomain already exists']);
        }

        // Unique Tenant ID and DB name
        $id = time();
        $dbName = 'tenant_' . $id;

        // Create tenant in main database
        $tenant = Tenant::create([
            'id' => $id,
            'data' => [
                'name' => $request->name,
                'contact' => $request->contact,
                'tenancy_db_name' => $dbName,
            ],
            'tenancy_db_name' => $dbName,
        ]);

        // Assign domain to tenant
        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        // Create tenant database if it does not exist
        DB::statement("CREATE DATABASE IF NOT EXISTS `$dbName`");

        // Initialize tenancy
        tenancy()->initialize($tenant);

        // Switch tenant database connection dynamically
        config(['database.connections.tenant.database' => $dbName]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Run tenant migrations
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);

        // End tenant context
        tenancy()->end();

        return redirect()->route('admin.hospitals.index')
            ->with('success', 'Hospital created successfully!');
    }

    public function edit($id)
    {
        $hospital = Tenant::with('domains')->findOrFail($id);
        $base = config('app.base_domain', 'main.localhost');

        $domain = optional($hospital->domains->first())->domain;
        $sub = $domain ? str_replace('.' . $base, '', $domain) : '';

        return view('admin.hospitals.edit', [
            'hospital' => $hospital,
            'subdomain' => $sub,
            'baseDomain' => $base
        ]);
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'name' => 'required|string',
            'contact' => 'nullable|string',
            'subdomain' => 'required|string|alpha_dash|min:3|max:100',
        ]);

        $tenant = Tenant::with('domains')->findOrFail($id);
        $base = config('app.base_domain', 'main.localhost');

        $domain = $r->subdomain . '.' . $base;

        $exists = TenantDomain::where('domain', $domain)
            ->where('tenant_id', '!=', $tenant->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['subdomain' => 'Subdomain already exists']);
        }

        // Update metadata
        $data = $tenant->data ?? [];
        $data['name'] = $r->name;
        $data['contact'] = $r->contact;

        $tenant->update(['data' => $data]);

        // Update or create domain
        if ($tenant->domains->first()) {
            $tenant->domains->first()->update(['domain' => $domain]);
        } else {
            $tenant->domains()->create(['domain' => $domain]);
        }

        return redirect()->route('admin.hospitals.index')->with('success', 'Updated!');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $name = $tenant->data['name'] ?? '';

        $tenant->delete(); // DB deleted by TenantDeleted event

        return back()->with('success', "Hospital $name deleted.");
    }
}
