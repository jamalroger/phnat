<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User  extends Model
{
    protected $fillable = [
        'email', 'phone', 'password', 'lang', 'country', 'last_login', 'last_seen'
    ];
}
