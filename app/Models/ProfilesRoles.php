<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilesRoles extends Model
{
    use HasFactory;

    protected $table = 'profiles_roles';

    protected $fillable = ['profile_id', 'role_id'];
}
