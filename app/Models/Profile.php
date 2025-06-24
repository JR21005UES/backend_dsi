<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    //
    use SoftDeletes;

     protected $fillable = [
        'name',
        'description',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'profile_role', 'profile_id', 'role_id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'profiles_menus', 'profile_id', 'menu_id');
    }
}
