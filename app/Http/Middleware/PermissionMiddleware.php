<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionMiddleware
{

    public function handle($request, Closure $next, $menu)
    {
        $user = Auth::user();

        $hasAccess = DB::table('sys_user_roles')
            ->join('sys_role_menu_permissions', 'sys_user_roles.role_id', '=', 'sys_role_menu_permissions.role_id')
            ->join('sys_menus', 'sys_menus.id', '=', 'sys_role_menu_permissions.menu_id')
            ->where('sys_user_roles.user_id', $user->id)
            ->where('sys_menus.menu_url', $menu)
            ->where('sys_role_menu_permissions.can_view', 1)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'No Permission');
        }
        return $next($request);
    }
}
