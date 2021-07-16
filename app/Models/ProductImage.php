<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $appends    = ['imageurl'];

    public function getImageurlAttribute()
    {
        $productpicurl = ENV('APP_URL').'/storage/'.$this->images;

        return $productpicurl;
    }

}
