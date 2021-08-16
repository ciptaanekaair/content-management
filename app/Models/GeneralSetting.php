<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_title', 
        'website_logo', 
        'keywords', 
        'website_description', 
        'midtrans_client_token', 
        'midtrans_server_token'
    ];

    protected $appends = ['imageurl'];

    public function getImageurlAttribute()
    {
        $logo = ENV('APP_URL').'/storage/'.$this->website_logo;

        return $logo;
    }
}
