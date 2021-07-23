<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelRole extends Model
{
    use HasFactory;

    protected $table    = 'level_role';
    protected $fillable = ['level_id', 'role_id'];

    public function Role()
    {
        return $this->belongsToMany(Role::class());
    }
}
