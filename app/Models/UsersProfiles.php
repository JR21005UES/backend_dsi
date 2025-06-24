<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersProfiles extends Model
{
    use HasFactory;

    protected $table = 'users_profiles';

    protected $fillable = ['user_id', 'profile_id', 'name', 'description', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
