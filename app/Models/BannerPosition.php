<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerPosition extends Model
{
    use HasFactory;

    protected $fillable = ['position_name', 'position_description'];

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
}
