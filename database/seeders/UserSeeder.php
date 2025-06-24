<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Profile;
use App\Models\ProfileMenu;
use App\Models\ProfilesRoles;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UsersProfiles;
use App\Models\Worker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        //crear usuarios
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('123123'),
            ],
            [
                'name' => 'Director',
                'email' => 'director@example.com',
                'password' => Hash::make('123123'),
            ],
            [
                'name' => 'Administrador Academico',
                'email' => 'academico@example.com',
                'password' => Hash::make('123123'),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('123123'),
            ],
        ];

        $profiles = [
            [
                'name' => 'ADMIN',
                'description' => 'Perfil de administrador con acceso completo al sistema.',
            ],
            [
                'name' => 'DIRECTOR',
                'description' => 'Perfil de director con acceso a funciones administrativas.',
            ],
            [
                'name' => 'ADMINISTRADOR_ACADEMICO',
                'description' => 'Perfil de administrador académico con acceso a funciones académicas.',
            ],
            [
                'name' => 'DOCENTE',
                'description' => 'Perfil de docente con acceso a funciones docentes.',
            ]
        ];
        //Ahora quiero que se llene la tabla users_profiles con los usuarios y perfiles creados
        foreach ($users as $userData) {
            User::create($userData);
        }
        foreach ($profiles as $profileData) {
            Profile::create($profileData);
        }
    // Asignar perfiles a usuarios
        $this->attachUserProfile('admin@example.com', 'ADMIN', 1);
        $this->attachUserProfile('director@example.com', 'DIRECTOR', 1);
        $this->attachUserProfile('academico@example.com', 'ADMINISTRADOR_ACADEMICO', 1);
        $this->attachUserProfile('user@example.com', 'DOCENTE', 1);
    }

    private function attachUserProfile($email, $profileName, $createdBy)
    {
        $user = User::where('email', $email)->first();
        $profile = Profile::where('name', $profileName)->first();

        if ($user && $profile) {
            UsersProfiles::create([
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'created_by' => $createdBy,
            ]);
        }
    }
}