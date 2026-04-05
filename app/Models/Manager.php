<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Manager extends Model

{
    use HasApiTokens, HasRoles, SoftDeletes;
    protected $fillable = ['name', 'email', 'password', 'deleted_at', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
}
