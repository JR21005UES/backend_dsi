<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'uri',
        'order',    
        'show'
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profiles_menus', 'menu_id', 'profile_id');
    }
}
