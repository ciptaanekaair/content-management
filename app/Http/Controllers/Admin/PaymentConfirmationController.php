<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentConfirmation;
use App\Models\Transaction;
use App\Models\RekamJejak;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class PaymentConfirmationController extends Controller
{
    public function getDetail($id)
    {
        if ($this->authorize('MOD1108-read')) {
            $pConfirmation = PaymentConfirmation::select('id', 'user_id', 'deskripsi', 'images', 'status', 'created_at')
                            ->where('transactions_id', $id)
                            ->get();

            if (!empty($pConfirmation)) {
                return view('admin.transaksi.table-payment', compact('pConfirmation'));
            }

            return view('admin.transaksi.table-payment', compact(['pConfirmation' => new PaymentConfirmation]));
        }
    }

    public function verify($id)
    {
        if ($this->authorize('MOD1108-update')) {
            $pConfirmation = PaymentConfirmation::find($id);

            if (!empty($pConfirmation)) {
                $pConfirmation->status = 1;
                $pConfirmation->update();

                $transaction = Transaction::find($pConfirmation->transactions_id);
                $transaction->status = 7;
                $transaction->update();

                $rekam = new RekamJejak;
                $rekam->user_id     = auth()->user()->id;
                $rekam->modul_code  = '[MOD1104] products';
                $rekam->action      = 'Create';
                $rekam->description = 'User: '.auth()->user()->email.' membuat data: '.
                                        $product->product_name.', dengan ID: '.$product->id.
                                        '. Pada: '.date('Y-m-d H:i:s').'.';
                $rekam->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil verifikasi data pembayaran.'
                ], 200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database.'
            ], 401);
        }
    }

    public function unverify($id)
    {
        if ($this->authorize('MOD1108-update')) {
            $pConfirmation = PaymentConfirmation::find($id);

            if (!empty($pConfirmation)) {
                $pConfirmation->status = 0;
                $pConfirmation->update();

                $transaction = Transaction::find($pConfirmation->transactions_id);
                $transaction->status = 2;
                $transaction->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil non-verifikasi data pembayaran.'
                ],200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database.'
            ], 401);
        }
    }

    public function terminated($id)
    {
        if ($this->authorize('MOD1108-update')) {
            $pConfirmation = PaymentConfirmation::find($id);

            if (!empty($pConfirmation)) {
                $pConfirmation->status = 9;
                $pConfirmation->update();

                $transaction = Transaction::find($pConfirmation->transactions_id);
                $transaction->status = 0;
                $transaction->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil membatalkan pembayaran.'
                ],200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database.'
            ], 401);
        }
    }
}
