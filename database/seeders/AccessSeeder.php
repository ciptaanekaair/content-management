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
        $admin1 = Level::findOrFail(1);
        $admin1->aksesRole()->attach([1, 2, 3, 4, 5]);

        $admin2 = Level::findOrFail(2);
        $admin2->aksesRole()->attach([1, 2, 3, 4, 5]);

        $admin3 = Level::findOrFail(3);
        $admin3->aksesRole()->attach([1, 2, 3, 4, 5]);
    }
}
