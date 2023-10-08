<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\r as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class r extends Model
{
    use HasFactory;
    protected $table = 'register';
    protected $fillable =
    [
        'name','email','password'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
     protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
