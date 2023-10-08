<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

class Data extends Model
{
    protected $table = 'datas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        "name",
        "email",
        "country",
        "state",
        "city",
    ];
}