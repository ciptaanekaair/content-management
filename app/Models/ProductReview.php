<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'transaction_id',
        'stars', 
        'detail_review', 
        'status'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}





