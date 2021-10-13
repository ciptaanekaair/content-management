<?php

namespace App\Models;

use Auth;
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
        if (Auth::check()) {
            $cek = $this->Liked()->where('product_id', $this->id)
                        ->where('user_id', auth()->user()->id)
                        ->first();

            if (!empty($cek)) {
                return true;
            }

            return false;
        }

        return false;
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
