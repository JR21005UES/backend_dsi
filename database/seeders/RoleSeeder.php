<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Profile;
use App\Models\ProfilesRoles;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = [
            [
                'name' => 'ROLE_ADMIN',
                'description' => 'Permite administrar el sistema',
            ],
            [
                'name' => 'ROLE_USER_LIST',
                'description' => 'Permite listar usuarios',
            ],
            [
                'name' => 'ROLE_USER_CREATE',
                'description' => 'Permite crear usuarios',
            ],
            [
                'name' => 'ROLE_USER_UPDATE',
                'description' => 'Permite actualizar usuarios',
            ],
            [
                'name' => 'ROLE_USER_DELETE',
                'description' => 'Permite eliminar usuarios',
            ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

        // Asignar roles a perfiles
        $this->attachProfileRole('ROLE_ADMIN', 'ADMIN');
        
        $this->attachProfileRole('ROLE_USER_LIST', 'DIRECTOR');
        $this->attachProfileRole('ROLE_USER_LIST', 'ADMINISTRADOR_ACADEMICO');

        $this->attachProfileRole('ROLE_USER_CREATE', 'ADMINISTRADOR_ACADEMICO');

        $this->attachProfileRole('ROLE_USER_UPDATE', 'ADMINISTRADOR_ACADEMICO');
 
        $this->attachProfileRole('ROLE_USER_DELETE', 'ADMINISTRADOR_ACADEMICO');  

    }
    private function attachProfileRole($roleName, $profileName)
    {
        $role = Role::where('name', $roleName)->first();
        $profile = Profile::where('name', $profileName)->first();

        if ($role && $profile) {
            ProfilesRoles::create([
                'profile_id' => $profile->id,
                'role_id' => $role->id,
            ]);
        }
    }
}
