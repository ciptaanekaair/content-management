<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    use HasFactory;

    protected $fillable = ['transactions_id',
                            'user_id',
                            'deskripsi',
                            'images',
                            'status'
                        ];

    protected $appends    = ['imageurl', 'payment_confirmation_id'];

    public function getImageurlAttribute()
    {
        $productpicurl = ENV('APP_URL').'/storage/'.$this->images;

        return $productpicurl;
    }

    public function getPaymentConfirmationIdAttribute()
    {
        return $this->id;
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

}
