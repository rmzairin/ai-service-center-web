<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Admin extends Model
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
