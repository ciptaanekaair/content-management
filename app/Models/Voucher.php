<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $dates = ['voucher_end'];

    public function getTransaction()
    {
        return $this->belongsToMany(Transaction::class);
    }

    public function getDiscount($id)
    {
        return $this->select('vouchers.voucher_price')->where('id', $id)->first();
    }
}
