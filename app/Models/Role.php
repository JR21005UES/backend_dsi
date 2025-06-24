<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'profiles_roles');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_profiles');
    }
}
