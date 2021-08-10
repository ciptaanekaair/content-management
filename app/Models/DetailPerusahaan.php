<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPerusahaan extends Model
{
    use HasFactory;

    protected $appends    = ['imageurl', 'status_perusahaan'];

    public function getImageurlAttribute()
    {
        if ($this->npwp_image == '') {
            $npwppicurl = '';
        } else {
            $npwppicurl = ENV('APP_URL').'/storage/'.$this->npwp_image;
        }

        return $npwppicurl;
    }

    public function getStatusPerusahaanAttribute()
    {
        if ($this->status == 0) {
            $this->status_perusahaan = 'unverified';
        } elseif ($this->status == 1) {
            $this->status_perusahaan = 'verified';
        } else {
            $this->status_perusahaan = 'error';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
