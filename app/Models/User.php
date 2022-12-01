<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'idp_customers';
    protected $primaryKey = 'id_customer';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'password', 'phone', 'user_role', 'company', 'customer_group_id', 'price_group_id', 'token', 'active', 'google'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime'];
}
