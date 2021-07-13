<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\RoleCategory;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            // 'level_id' => 3,
            'nama_role' => 'product-read'
        ]);
        Role::create([
            // 'level_id' => 3,
            'nama_role' => 'product-create'
        ]);
        Role::create([
            // 'level_id' => 3,
            'nama_role' => 'product-edit'
        ]);
        Role::create([
            // 'level_id' => 3,
            'nama_role' => 'product-update'
        ]);
        Role::create([
            // 'level_id' => 3,
            'nama_role' => 'product-delete'
        ]);

        Role::create([
            // 'level_id' => 3,
            'nama_role' => 'spesial'
        ]);
    }
}
