<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role    Nombre de rol
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role = '')
    {

        // Libre albedrío (Comentar línea para reactivar middleware)
        // return $next($request);

        // Lista de roles existentes
        $roleArray = [
            'admin' => [1],
            'reader' => [2],
            'author' => [3],
        ];


        // Continuar/Autorizar solicitud para admin
        if (in_array(auth()->user()->role_id, $roleArray['admin'])) {
            return $next($request);
        }

        // Validación y toma de ids de rol
        $role_ids = $roleArray[$role] ?? [];

        // Abortar solicitud si es usuario invitado o si no se posee el rol
        if (auth()->guest() || (!in_array(auth()->user()->role_id, $role_ids))) {
            abort(403, 'Not authorized user');
        }

        // Continuar/Autorizar solicitud
        return $next($request);
    }
}
