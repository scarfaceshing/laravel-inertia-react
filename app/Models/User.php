<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
 use HasApiTokens;
 use HasFactory;
 use Notifiable;
 use HasRoles;
 use HasPermissions;

 public const ADMINISTRATOR_ID = 1;

 /**
  * The attributes that are mass assignable.
  *
  * @var array<int, string>
  */
 protected $fillable = [
  'username',
  'name',
  'email',
  'password',
  'is_active'
 ];

 /**
  * The attributes that should be hidden for serialization.
  *
  * @var array<int, string>
  */
 protected $hidden = [
  'password',
  'remember_token',
 ];

 /**
  * The attributes that should be cast.
  *
  * @var array<string, string>
  */
 protected $casts = [
  'email_verified_at' => 'datetime',
 ];

 // TODO: add relationship for roles and permission and also add traits to easy add permission or role
}
