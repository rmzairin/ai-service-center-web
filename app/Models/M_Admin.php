<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class M_Admin extends Authenticatable   
{
    protected $table = 'admins';
    protected $fillable = ['name' , 'email', 'password', 'role', 'status'];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
