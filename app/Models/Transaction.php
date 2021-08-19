<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $appends = ['status_transaksi', 'shipping_status'];

    public function getStatusTransaksiAttribute()
    {
        if ($this->status == 0) {
            $status_transaksi = 'Belum Di Bayar';
        } 
        elseif ($this->status == 1) {
            $status_transaksi = 'Success';
        }
        elseif ($this->status == 2) {
            $status_transaksi = 'Proses Verifikasi Pembayaran';
        }
        elseif ($this->status == 3) {
            $status_transaksi = 'Pengemasan';
        }
        elseif ($this->status == 4) {
            $status_transaksi = 'Pengiriman';
        }
        elseif ($this->status == 5) {
            $status_transaksi = 'Diterima';
        }
        elseif ($this->status == 6) {
            $status_transaksi = 'Dibatalkan';
        }
        elseif ($this->status == 7) {
            $status_transaksi = 'Pembayaran Terverifikasi';
        }

        return $status_transaksi;
    }

    public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }

    public function getShippingStatusAttribute()
    {
        $data = $this->shipping()->where('transaction_id', $this->id)->first();

        if (!empty($data)) {
            $status = $data->status;
        } else {
            //  buat status yang menerangkan bahwa tidak ada data shipping.
            $status = 99;
        }

        return $status;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentCode::class, 'payment_code_id', 'id');
    }

    public function getVoucher()
    {
        return $this->belongsToMany(Voucher::class);
    }

    public function getDiscount($id)
    {
        return $this->getVoucher()->where('id', $id)->first();
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }

    public function paymentConfirmation()
    {
        return $this->hasMany(PaymentConfirmation::class, 'transactions_id', 'id');
    }

    public function productReview()
    {
        return $this->hasOne(ProductReview::class);
    }
}
