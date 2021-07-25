<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

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
