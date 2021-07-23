<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provinsi;


class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provinsi::create([
            'provinsi_name' => 'Aceh', // 2
            'provinsi_code' => 'AC'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sumatera Utara', // 3
            'provinsi_code' => 'SU'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sumatera Barat', // 4
            'provinsi_code' => 'SB'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Riau', // 5
            'provinsi_code' => 'RI'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Jambi', // 7
            'provinsi_code' => 'JA'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sumatera Selatan', // 9
            'provinsi_code' => 'SS'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Bengkulu', // 8
            'provinsi_code' => 'BE'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Lampung', // 11
            'provinsi_code' => 'LA'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Bangka Belitung', // 10
            'provinsi_code' => 'BB'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Kepulauan Riau', // 6
            'provinsi_code' => 'KR'
        ]);
        Provinsi::create([
            'provinsi_name' => 'DKI Jakarta', // 14
            'provinsi_code' => 'JK'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Jawa Barat', // 13
            'provinsi_code' => 'JB'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Jawa Tengah', // 15
            'provinsi_code' => 'JT'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Yogyakarta', // 16
            'provinsi_code' => 'YO'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Jawa Timur', // 17
            'provinsi_code' => 'JI'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Banten', // 12
            'provinsi_code' => 'BT'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Bali', // 18
            'provinsi_code' => 'BA'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Nusa Tenggara Barat', // 19
            'provinsi_code' => 'NB'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Nusa Tenggara Timur', // 20
            'provinsi_code' => 'NT'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Kalimantan Barat', // 21
            'provinsi_code' => 'KB'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Kalimantan Tengah', // 23
            'provinsi_code' => 'KT'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Kalimantan Selatan', // 22
            'provinsi_code' => 'KS'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Kalimantan Timur', // 24
            'provinsi_code' => 'KI'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Kalimantan Utara', // 25
            'provinsi_code' => 'KU'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sulawesi Utara', // 31
            'provinsi_code' => 'SA'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sulawesi Tengah', // 29
            'provinsi_code' => 'ST'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sulawesi Selatan', // 28
            'provinsi_code' => 'SN'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sulawesi Tenggara', // 30
            'provinsi_code' => 'SG'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Gorontalo', // 26
            'provinsi_code' => 'GO'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Sulawesi Barat', // 27
            'provinsi_code' => 'SR'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Maluku', // 32
            'provinsi_code' => 'MA'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Maluku Utara', // 33
            'provinsi_code' => 'MU'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Papua barat', // 34
            'provinsi_code' => 'PB'
        ]);
        Provinsi::create([
            'provinsi_name' => 'Papua', // 35
            'provinsi_code' => 'PA'
        ]);
    }
}
