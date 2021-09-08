<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends    = ['imageurl'];

    public function getImageurlAttribute()
    {
        $productpicurl = ENV('APP_URL').'/storage/'.$this->product_images;

        return $productpicurl;
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function carts()
    {
        return $this->belongsTo(TransactionTemporary::class);
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function countQty()
    {
        return $this->transactionDetail()->sum('qty');
    }

    public function Discount()
    {
        return $this->hasOne(Discount::class);
    }
}
