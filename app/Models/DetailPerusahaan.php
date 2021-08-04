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
        if ($this->npwp_image == '') {
            $npwppicurl = '';
        } else {
            $npwppicurl = ENV('APP_URL').'/storage/'.$this->npwp_image;
        }

        return $npwppicurl;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
