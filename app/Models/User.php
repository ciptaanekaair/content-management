<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'level_id',
        'username',
        'password',
        'company',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function Level()
    {
        return $this->belongsTo(Level::class);
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function hasAccess($role)
    {
        return $this->Level->aksesRole()->where('nama_role', $role)->first() ?: false;
    }

    public function carts()
    {
        return $this->hasMany(TransactionTemporary::class);
    }

    public function detailPerusahaan()
    {
        return $this->hasOne(DetailPerusahaan::class);
    }

    public function perusahaanDetail()
    {
        $data = array();

        if ($this->company == 1) {
            return $this->detailPerusahaan()->where('user_id', $this->id)->first();
        }

        return $data;
    }

    // public function loadCartData()
    // {
    //     return $this->hasMany(TransactionTemporary::class);
    // }

    public function countQty()
    {
        return $this->carts()->sum('qty');
    }

    public function countTotalPrice()
    {
        return $this->carts()->sum('total_price');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
