<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    use  HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('user_name', 'email', 'password', 'phone', 'image', 'slug');

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
        // TODO: Implement getActivitylogOptions() method.
    }
}
