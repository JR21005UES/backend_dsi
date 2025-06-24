<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\ProfileMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsersProfiles;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (isAdmin()) {
            //si es admin, devuelve todos los menus excluyendo los timestamps
            $menus = Menu::all(['id', 'name', 'icon', 'uri', 'order']);
            return response()->json($menus, 200);
        }else{

        $user = Auth::user();
        //dame TODOS los perfiles del usuario
        $profiles = UsersProfiles::where('user_id', $user->id)->pluck('profile_id')->toArray();

        //dame todos los menus que tenga cada perfil
        $arrayMenus = ProfileMenu::whereIn('profile_id', $profiles)->pluck('menu_id')->toArray();

        //dame los menus dentro del array de menus excluyendo los timestamps
        $menus = Menu::whereIn('id', $arrayMenus)->get(['id', 'name', 'icon', 'uri', 'order']);

        return response()->json($menus, 200);
}
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
