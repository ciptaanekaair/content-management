<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends    = ['imageurl', 'liked', 'likedCount'];

    public function getImageurlAttribute()
    {
        $productpicurl = ENV('APP_URL').'/storage/'.$this->product_images;

        return $productpicurl;
    }

    public function getLikedAttribute()
    {
        if (isset(auth()->user()->id)) {
            $cek = $this->Liked->where('user_id', auth()->user()->id)
                        ->where('product_id', $this->id)
                        ->first();

            if (!empty($cek)) {
                return true;
            }

            return false;
        }
    }

    public function getLikedCountAttribute()
    {
        return $jumlah = $this->Liked()->count();
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

    public function Liked()
    {
        return $this->hasMany(ProductLiked::class);
    }
}
