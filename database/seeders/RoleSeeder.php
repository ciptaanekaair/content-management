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

        // Transaction
        Role::create([
            'nama_role' => 'MOD1008-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1008-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1008-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1008-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1008-delete'
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

        // Provinsi Modul
        Role::create([
            'nama_role' => 'MOD1300-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1300-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1300-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1300-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1300-delete'
        ]);

        // Kota Modul
        Role::create([
            'nama_role' => 'MOD1301-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1301-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1301-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1301-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1301-delete'
        ]);

        // Laporan Transaction
        Role::create([
            'nama_role' => 'MOD2001-read'
        ]);
        Role::create([
            'nama_role' => 'MOD2001-create'
        ]);
        Role::create([
            'nama_role' => 'MOD2001-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD2001-update'
        ]);
        Role::create([
            'nama_role' => 'MOD2001-delete'
        ]);

        // Banner Position
        Role::create([
            'nama_role' => 'MOD1100-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1100-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1100-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1100-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1100-delete'
        ]);

        // Banners
        Role::create([
            'nama_role' => 'MOD1101-read'
        ]);
        Role::create([
            'nama_role' => 'MOD1101-create'
        ]);
        Role::create([
            'nama_role' => 'MOD1101-edit'
        ]);
        Role::create([
            'nama_role' => 'MOD1101-update'
        ]);
        Role::create([
            'nama_role' => 'MOD1101-delete'
        ]);


        Role::create([
            'nama_role' => 'spesial'
        ]);
    }
}
