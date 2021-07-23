<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Voucher::create([
            'voucher_code'   => 'kartini2021',
            'voucher_name'   => 'Peringatan Hari Kartini.',
            'voucher_detail' => 'Voucher pengurangan harga dalam memperingati Hari Kartini. Berlaku sampai 31 Juli 2021',
            'voucher_price'  => '250000',
            'voucher_end'    => '2021-07-31',
        ]);

        Voucher::create([
            'voucher_code'   => 'filterpedia2021',
            'voucher_name'   => 'Grand launching voucher.',
            'voucher_detail' => 'FilterPedia grand launching voucher, berlaku hanya sampai 30 Agustus 2021',
            'voucher_price'  => '500000',
            'voucher_end'    => '2021-08-31',
        ]);

    }
}
