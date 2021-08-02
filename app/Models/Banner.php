<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_name',
        'banner_image'
    ];

    protected $appends    = ['imageurl'];

    public function getImageurlAttribute()
    {
        $bannerpicurl = ENV('APP_URL').'/storage/'.$this->banner_image;

        return $bannerpicurl;
    }

    public function bannerPosition()
    {
        return $this->belongsTo(BannerPosition::class);
    }
}
