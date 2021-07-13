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

        // Users
        Role::create([
            'nama_role' => 'MOD1001-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1001-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1001-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1001-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1001-delete'
        ]);

        // Level
        Role::create([
            'nama_role' => 'MOD1002-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1002-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1002-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1002-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1002-delete'
        ]);

        // Roles
        Role::create([
            'nama_role' => 'MOD1102-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1102-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1102-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1102-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1102-delete'
        ]);

        // P. Category
        Role::create([
            'nama_role' => 'MOD1004-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1004-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1004-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1004-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1004-delete'
        ]);

        // Product
        Role::create([
            'nama_role' => 'MOD1104-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1104-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1104-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1104-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1104-delete'
        ]);

        // Product Images
        Role::create([
            'nama_role' => 'MOD1204-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1204-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1204-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1204-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1204-delete'
        ]);

        // Product Reviews
        Role::create([
            'nama_role' => 'MOD1009-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1009-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1009-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1009-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1009-delete'
        ]);


        Role::create([
            'nama_role' => 'spesial'
        ]);
    }
}
