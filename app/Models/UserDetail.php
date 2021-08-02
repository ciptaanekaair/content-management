<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pt',
        'teleon',
        'handphone',
        'alamat',
        'provinsi_id',
        'kota_id',
        'kode_pos'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
