<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use App\Models\UsersProfiles;



class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Valor por defecto: 10
        $email = $request->query('email');

        $query = User::query();
        if ($email) {
            $query->where('email', 'like', "%$email%");
        }
        $usuarios = $query->paginate($perPage);
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json('Error en la validación de los datos', 400);
        }
        $usuario = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        return response()->json('Usuario creado', 201);
    }

    public function update(Request $request, $id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json('Usuario no encontrado', 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json('Error en la validación de los datos', 400);
        }
        
        $usuario->name = $request['name'];
        $usuario->save();
        return response()->json('Usuario actualizado', 201);
    }

    public function destroy($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json('Usuario no encontrado', 404);
        }
        $usuario->delete();
        return response()->json('Usuario eliminado', 201);
    }

    public function restore($id)
    {
        $usuario = User::withTrashed()->find($id);
        if (!$usuario) {
            return response()->json('Usuario no encontrado', 404);
        }
        $usuario->restore();
        return response()->json('Usuario restaurado', 200);
    }

    public function show($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json('Usuario no encontrado', 404);
        }
        return response()->json($usuario, 200);
    }
    //funcion indexUserProfile
    public function indexUserProfile()
    {
        //obtener todos los registros de la tabla UsersProfiles
        $userProfiles = UsersProfiles::with(['user', 'profile'])->get();
        if ($userProfiles->isEmpty()) {
            return response()->json('No hay registros de usuarios-perfiles', 404);
        }
        return response()->json($userProfiles, 200);
    }   

    //Funcion para agregar a la tabla pivote UsersProfiles
    public function storeUserProfile(Request $request)
    {
        //validar name, description, user_id y profile_id. ingresar el created_by del usuario que realiza la peticion
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required|exists:profiles,id',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json('Error en la validación de los datos', 400);
        }
        //buscar el usuario por id
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json('Usuario no encontrado', 404);
        }   
        //buscar el perfil por id
        $profile = Profile::find($request->profile_id);
        if (!$profile) {    
            return response()->json('Perfil no encontrado', 404);
        }   
        //verificar si el usuario ya tiene el perfil
        $existingUserProfile = UsersProfiles::where('user_id', $request->user_id)
            ->where('profile_id', $request->profile_id)
            ->first();
        if ($existingUserProfile) {
            return response()->json('El usuario ya tiene este perfil', 409);
        }   
        //crear el registro en la tabla UsersProfiles
        $userProfile = new UsersProfiles();
        $userProfile->user_id = $request->user_id;
        $userProfile->profile_id = $request->profile_id;
        $userProfile->created_by = $request->user()->id; // Asignar el ID del usuario que realiza la petición
        if (!$userProfile->save()) {
            return response()->json('Error al agregar el perfil al usuario', 400);  
        }   
        return response()->json('Perfil agregado al usuario', 200);
    }

    //Funcion para eliminar un perfil de un usuario
    public function destroyUserProfile($id)
    {
        //buscar el registro en la tabla UsersProfiles por id
        $userProfile = UsersProfiles::find($id);
        if (!$userProfile) {
            return response()->json('Registro no encontrado', 404);
        }
        //eliminar el registro
        if (!$userProfile->delete()) {
            return response()->json('Error al eliminar el perfil del usuario', 400);
        }
        return response()->json('Perfil eliminado del usuario', 200);
    }
}
