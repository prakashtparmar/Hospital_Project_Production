<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            UserSeeder::class,
            TenantDomainSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            DummyScheduleSeeder::class,
            WardTypeSeeder::class,
            RoomTypeSeeder::class,
            BedTypeSeeder::class,

            MedicineCategorySeeder::class,
            MedicineUnitSeeder::class,
            MedicineSeeder::class,
            SupplierSeeder::class,
            PurchaseSeeder::class,



        ]);
    }
}
