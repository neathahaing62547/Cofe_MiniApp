<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
