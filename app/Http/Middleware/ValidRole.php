<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\ProfilesRoles;
use App\Models\UsersProfiles;
use App\Models\Role;


class ValidRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();
        //dame TODOS los perfiles del usuario
        $profiles = UsersProfiles::where('user_id', $user->id)->pluck('profile_id')->toArray();

        //recorre el array de profiles y dame todos los roles que tenga cada perfil
        $profileRoles = ProfilesRoles::whereIn('profile_id', $profiles)->pluck('role_id')->toArray();

        //dame los nombres de los roles dentro del array de roles
        $arrayRoles = Role::whereIn('id', $profileRoles)->pluck('name')->toArray();
        
        //valida si en roles existe ROLE_ADMIN
        if (in_array("ROLE_ADMIN", $arrayRoles)) {
            //si existe, continua con la peticion
            return $next($request);
        }else if (in_array($role, $arrayRoles)) {
            //si existe el rol que se le envio, continua con la peticion
            return $next($request);
        }else {
            //si no existe, retorna un bad request sin errorresponse
            return response()->json('No tienes permisos para realizar esta accion', 403);
        }
    }
}
