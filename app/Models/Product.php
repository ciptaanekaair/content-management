<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends    = ['imageurl'];
    // protected $attributes = ['product_price'];

    public function getImageurlAttribute()
    {
        $productpicurl = ENV('APP_URL').'/storage/'.$this->product_images;

        return $productpicurl;
    }

    // public function setProductPriceAttribute()
    // {
    //     return (int)$this->product_price;
    // }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

}
