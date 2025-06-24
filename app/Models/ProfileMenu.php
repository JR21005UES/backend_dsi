<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileMenu extends Model
{

    protected $table = 'profiles_menus';

    protected $fillable = [
        'profile_id',
        'menu_id',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
    
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
