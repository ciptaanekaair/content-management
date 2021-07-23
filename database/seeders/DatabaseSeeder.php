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
        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            CreateUserSeeder::class,
            CreateKodePayment::class,
            RoleSeeder::class,
            AccessSeeder::class,
            VoucherSeeder::class,
            ProvinsiSeeder::class,
            // KotaSeeder::class,
        ]);
    }
}
