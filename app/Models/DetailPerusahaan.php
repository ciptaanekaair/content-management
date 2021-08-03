<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPerusahaan extends Model
{
    use HasFactory;

    protected $appends    = ['imageurl'];

    public function getImageurlAttribute()
    {
        $npwppicurl = ENV('APP_URL').'/storage/'.$this->npwp_image;

        return $npwppicurl;
    }
}
