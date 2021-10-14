<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Level;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'id'           => 1,
            'nama_level'   => 'Pengguna Apps',
            'detail_level' => 'User dengan hak akses sebagai pengguna Apps / buyer melalui Frontend.',
            'status'       => 1
        ]);
        Level::create([
            'id'           => 2,
            'nama_level'   => 'Admin 1',
            'detail_level' => 'Admin yang bertugas untuk menginput kategori barang, data barang, dll.',
            'status'       => 1
        ]);
        Level::create([
            'id'           => 3,
            'nama_level'   => 'Admin 2',
            'detail_level' => 'Admin yang bertugas untuk menginput kode pengiriman barang, perubahan status order, dll.',
            'status'       => 1
        ]);
        Level::create([
            'id'           => 4,
            'nama_level'   => 'Super Admin',
            'detail_level' => 'Admin dengan role akses dan penggunaan untuk semua menu yang ada.',
            'status'       => 1
        ]);
        Level::create([
            'id'           => 5,
            'nama_level'   => 'Pending Registration',
            'detail_level' => 'User tidak dapat ditunakan kecuali sudah melakukan aktifasi email.',
            'status'       => 1
        ]);
        Level::create([
            'id'           => 6,
            'nama_level'   => 'Kurir',
            'detail_level' => 'User khusus untuk para staff pengiriman barang.',
            'status'       => 1
        ]);
        Level::create([
            'id'           => 9,
            'nama_level'   => 'Banned User',
            'detail_level' => 'User dengan hak akses ini, merupakan user yang di blok/banned oleh Admin.',
            'status'       => 1
        ]);

        $user = new User;
        $user->name               = 'Saldi';
        $user->email              = 'saldi@localhost.com';
        $user->username           = md5('saldi@localhost.com');
        $user->password           = Hash::make('123456');
        $user->email_verified_at  = '2021-07-06 00:00:00';
        $user->level_id           = 4;
        $user->profile_photo_path = 'profile-photos/user.png';
        $user->save();

        $user = new User;
        $user->name               = 'Ridwan';
        $user->email              = 'ridwan@localhost.com';
        $user->username           = md5('ridwan@localhost.com');
        $user->password           = Hash::make('123456');
        $user->email_verified_at  = '2021-07-06 00:00:00';
        $user->level_id           = 4;
        $user->profile_photo_path = 'profile-photos/user.png';
        $user->save();
    }
}
