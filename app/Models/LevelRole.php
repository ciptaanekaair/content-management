<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelRole extends Model
{
    use HasFactory;

    protected $table = 'level_role';

    public function Role()
    {
        return $this->belongsToMany(Role::class());
    }
}
