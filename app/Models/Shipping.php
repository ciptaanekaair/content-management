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
        'kurir_id',
        'keterangan',
        'status'
    ];

}
