<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin1 = Level::findOrFail(2);
        $admin1->aksesRole()->attach([
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26 ,27, 28, 29, 30,
            31, 32, 33, 34, 35
        ]);

        $admin2 = Level::findOrFail(3);
        $admin2->aksesRole()->attach([
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26 ,27, 28, 29, 30,
            31, 32, 33, 34, 35
        ]);

        $superuser = Level::findOrFail(4);
        $superuser->aksesRole()->attach([
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26 ,27, 28, 29, 30,
            31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
            41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
            51, 52, 53, 54, 55, 56, 57, 58, 59, 60,
            61, 62, 63, 64, 65, 66
        ]);
    }
}
