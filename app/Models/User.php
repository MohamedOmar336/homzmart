<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'users';
    use   SoftDeletes, HasApiTokens;

    protected $dates = ['deleted_at'];
    protected $fillable = array('first_name', 'last_name', 'user_name',
        'email', 'password' , 'phone' , 'image' );

    protected $hidden = [
        'password',
        'old_password',
        'salt',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
        // TODO: Implement getActivitylogOptions() method.
    }

}
