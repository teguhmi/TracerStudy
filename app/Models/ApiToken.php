<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $fillable = [
        'service',
        'token',
        'expires_at',
    ];

//    protected function casts(): array
//    {
//        return [
//            'token' => 'encrypted',
//            'expires_at' => 'datetime',
//        ];
//    }
}
