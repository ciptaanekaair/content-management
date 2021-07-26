<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $appends = ['status_transaksi'];

    public function getStatusTransaksiAttribute()
    {
        if ($this->status == 0) {
            $status_transaksi = 'Unpaid';
        } 
        elseif ($this->status == 1) {
            $status_transaksi = 'Success';
        }
        elseif ($this->status == 2) {
            $status_transaksi = 'Ferivy Payment';
        }
        elseif ($this->status == 3) {
            $status_transaksi = 'Pengemasan';
        }
        elseif ($this->status == 4) {
            $status_transaksi = 'Pengiriman';
        }
        elseif ($this->status == 4) {
            $status_transaksi = 'Diterima';
        }

        return $status_transaksi;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->hasMany(TransactionDetail::class);
    }
}
