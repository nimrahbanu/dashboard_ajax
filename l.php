<?php
 
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\l as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class l extends Authenticatable
  {
      use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;
    protected $table = 'register';
    protected $fillable = [
      'name',
      'email',
      'password',
  ];    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
