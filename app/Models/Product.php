<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // protected $attributes = ['imageurl'];
    protected $appends    = ['imageurl'];

    public function getImageurlAttribute()
    {
        $productpicurl = ENV('APP_URL').'/storage/'.$this->product_images;

        return $productpicurl;
    }

}
