<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\ProfileMenu;
use App\Models\Profile;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'icon' => 'mdi-home',
                'uri' => '/dashboard',
                'order' => 1,
                'show' => true,
            ],
            [
                'name' => 'Usuarios',
                'icon' => 'mdi-account',
                'uri' => '/usuarios',
                'order' => 2,
                'show' => true,
            ],
        ];
        foreach ($menus as $menu) {
            Menu::create($menu);
        }
        // Asignar menus a perfiles
        $this->attachProfileMenu('Dashboard', 'ADMIN');
        $this->attachProfileMenu('Dashboard', 'DIRECTOR');
        $this->attachProfileMenu('Dashboard', 'ADMINISTRADOR_ACADEMICO');
        $this->attachProfileMenu('Dashboard', 'DOCENTE');
        $this->attachProfileMenu('Usuarios', 'ADMIN');
        $this->attachProfileMenu('Usuarios', 'DIRECTOR');
        $this->attachProfileMenu('Usuarios', 'ADMINISTRADOR_ACADEMICO');
    }
    //crea funcion para asignar los menus a los perfiles
    private function attachProfileMenu($menuName, $profileName)
    {
        $menu = Menu::where('name', $menuName)->first();
        $profile = Profile::where('name', $profileName)->first();
        if ($menu && $profile) {
            ProfileMenu::create([
                'menu_id' => $menu->id,
                'profile_id' => $profile->id,
            ]);
        }
    }
}
