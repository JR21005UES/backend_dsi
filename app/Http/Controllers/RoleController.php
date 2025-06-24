<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProfilesRoles;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json('Error en la validación de los datos', 400);
        }
        // Verificar si el rol ya existe
        $existingRole = Role::where('name', $request->name)->first();
        if ($existingRole) {
            return response()->json('El rol ya existe', 409);
        }
        $role = Role::create([
            'name' => $request['name'],
            'description' => $request['description'] ?? null,
        ]);
        return response()->json('Rol creado', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json('Rol no encontrado', 404);
        }
        return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json('Rol no encontrado', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json('Error en la validación de los datos', 400);
        }

        // Verificar si el nombre del rol ya existe
        $existingRole = Role::where('name', $request->name)
            ->where('id', '!=', $id) // Asegurarse de que no sea el mismo rol
            ->first();
        if ($existingRole) {
            return response()->json('El nombre del rol ya existe', 409);
        }

        $role->update([
            'name' => $request['name'],
            'description' => $request['description'] ?? null,
        ]);

        return response()->json('Rol actualizado', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json('Rol no encontrado', 404);
        }
        
        $role->delete();
        return response()->json('Rol eliminado', 200);
    }

    // Recuperar un rol eliminado
    public function restore($id)
    {
        $role = Role::withTrashed()->find($id);
        if (!$role) {
            return response()->json('Rol no encontrado', 404);      
        }
        $role->restore();
        return response()->json('Rol restaurado', 200);
    }

    //funcion indexProfileRole
    public function indexProfileRole()
    {
        $profileRoles = ProfilesRoles::with(['profile', 'role'])->get();
        if ($profileRoles->isEmpty()) {
            return response()->json('No hay perfiles-roles registrados', 404);
        }
        return response()->json($profileRoles, 200);
    }

    //crear el storeProfileRole
    public function storeProfileRole(Request $request)
    {
        //validar los datos name, description, id_profile, id_role
        $validator = Validator::make($request->all(), [
            'id_profile' => 'required|integer|exists:profiles,id',
            'id_role' => 'required|integer|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return response()->json('Error en la validación de los datos', 400);    
        }
        // Verificar si el perfil ya tiene este rol
        $existingProfileRole = ProfilesRoles::where('profile_id', $request->id_profile)
            ->where('role_id', $request->id_role)
            ->first();
        if ($existingProfileRole) {
            return response()->json('El perfil ya tiene este rol', 409);    
        }  
        // Crear el registro en la tabla ProfilesRoles
        ProfilesRoles::create([
            'profile_id' => $request['id_profile'],
            'role_id' => $request['id_role'],
        ]);
        return response()->json('Perfil-Rol creado', 200);

    }

    // Eliminar un perfil-rol
    public function destroyProfileRole($id)
    {
        $profileRole = ProfilesRoles::find($id);
        if (!$profileRole) {
            return response()->json('Perfil-Rol no encontrado', 404);       
        }
        $profileRole->delete();
        return response()->json('Perfil-Rol eliminado', 200);       

    }
}
