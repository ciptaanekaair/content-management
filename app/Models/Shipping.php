<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'tanggal_kirim',
        'tanggal_sampai',
        'user_id',
        'keterangan',
        'status'
    ];

    public function TransactionData()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function UserData()
    {
        return $this->belongsTo(User::class);
    }

}
