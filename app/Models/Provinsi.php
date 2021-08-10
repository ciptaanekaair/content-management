<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table    = 'provinsis';
    protected $fillable = ['provinsi_code', 'provinsi_name', 'status'];

    public function kota()
    {
        return $this->hasMany(Kota::class);
    }
}
