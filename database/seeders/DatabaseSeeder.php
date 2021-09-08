<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(
            [
                CounteriesSeeder::class,
                StatesSeeder::class,
                StatusesSeeder::class,
                PermissionTableSeeder::class,
                DeliveryCompaniesSeeder::class,
                BusinessPagesTableDataSeeder::class,
                PaymentTypeSeeder::class,
                AdminPagesTableDataSeeder::class,
                RoleSeeder::class,
                UpdateProductTypeSeeder::class,
                AramexSeeder::class,
                DefaultRolesSeeder::class
            ]
        );
    }
}
