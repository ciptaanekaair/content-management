<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentCode;


class CreateKodePayment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentCode::create([
            'kode_pembayaran'    => 'MANDIRI001',
            'nama_pembayaran'    => 'Via Bank Mandiri',
            'nama_bank'          => 'Bank Mandiri',
            'atas_nama_rekening' => 'PT. Cipta Aneka Air',
            'nomor_rekening'     => '123456789012',
            'cabang'             => 'KCP Kalideres, Tangerang Selatan'
        ]);

        PaymentCode::create([
            'kode_pembayaran'    => 'BCA001',
            'nama_pembayaran'    => 'Via Bank BCA',
            'nama_bank'          => 'Bank BCA (Bank Central Asia)',
            'atas_nama_rekening' => 'PT. Cipta Aneka Air',
            'nomor_rekening'     => '123456789012',
            'cabang'             => 'KCP Kalideres, Tangerang Selatan'
        ]);

        PaymentCode::create([
            'kode_pembayaran'    => 'BNI001',
            'nama_pembayaran'    => 'Via Bank BNI',
            'nama_bank'          => 'Bank BNI (Bank Negara Indonesia)',
            'atas_nama_rekening' => 'PT. Cipta Aneka Air',
            'nomor_rekening'     => '123456789012',
            'cabang'             => 'KCP Kalideres, Tangerang Selatan'
        ]);

        PaymentCode::create([
            'kode_pembayaran'    => 'MANDIRI002',
            'nama_pembayaran'    => 'Via Bank Mandiri',
            'nama_bank'          => 'Bank Mandiri',
            'atas_nama_rekening' => 'PT. Cipta Aneka Air',
            'nomor_rekening'     => '098765432112',
            'cabang'             => 'KCP Cikini, Jakarta Pusat'
        ]);
    }
}
