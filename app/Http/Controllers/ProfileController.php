<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::all();
        return response()->json($profiles);
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
        // Verificar si el perfil ya existe
        $existingProfile = Profile::where('name', $request->name)->first();
        if ($existingProfile) {
            return response()->json('El perfil ya existe', 409);
        }
        $profile = Profile::create([
            'name' => $request['name'],
            'description' => $request['description'] ?? null,
        ]);
        return response()->json('Perfil creado', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $profile = Profile::find($id);
        if (!$profile) {
            return response()->json('Perfil no encontrado', 404);
        }
        return response()->json($profile, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);
        if (!$profile) {
            return response()->json('Perfil no encontrado', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json('Error en la validación de los datos', 400);
        }

        // Verificar si el nombre del perfil ya existe
        $existingProfile = Profile::where('name', $request->name)
            ->where('id', '!=', $id) // Asegurarse de que no sea el mismo perfil
            ->first();
        if ($existingProfile) {
            return response()->json('El perfil ya existe', 409);
        }

        $profile->update([
            'name' => $request['name'],
            'description' => $request['description'] ?? null,
        ]);
        return response()->json('Perfil actualizado', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);
        if (!$profile) {
            return response()->json('Perfil no encontrado', 404);
        }

        // Eliminar el perfil
        if (!$profile->delete()) {
            return response()->json('Error al eliminar el perfil', 500);
        }

        return response()->json('Perfil eliminado', 200);
    }

    public function restore($id)
    {
        $profile = Profile::withTrashed()->find($id);
        if (!$profile) {
            return response()->json('Perfil no encontrado', 404);
        }

        if ($profile->restore()) {
            return response()->json('Perfil restaurado', 200);
        } else {
            return response()->json('Error al restaurar el perfil', 500);
        }
    }
}
