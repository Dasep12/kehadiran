<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

function get_user_menus()
{
    $user = Auth::user();

    if (!$user) {
        return [];
    }

    $menuIds = DB::table('sys_user_roles')
        ->join('sys_role_menu_permissions', 'sys_user_roles.role_id', '=', 'sys_role_menu_permissions.role_id')
        ->where('sys_user_roles.user_id', $user->id)
        ->where('sys_role_menu_permissions.can_view', 1)
        ->pluck('sys_role_menu_permissions.menu_id')
        ->toArray();

    return Menu::whereIn('id', $menuIds)
        ->whereNull('parent_id')
        ->with(['children' => function ($q) use ($menuIds) {
            $q->whereIn('id', $menuIds);
        }])
        ->orderBy('sort_no')
        ->get();
}

function has_permission($menuUrl, $permission = 'view')
{
    $user = auth()->user();

    if (!$user) {
        return false;
    }

    // SUPER ADMIN
    if ($user->role_id == 1) {
        return true;
    }

    // CARI MENU
    $menu = DB::table('sys_menus')
        ->where('menu_url', $menuUrl)
        ->first();

    if (!$menu) {
        return false;
    }

    // MAP PERMISSION
    $column = match ($permission) {

        'view' => 'can_view',
        'create' => 'can_create',
        'edit' => 'can_edit',
        'delete' => 'can_delete',

        default => 'can_view'
    };

    return DB::table('sys_user_roles')
        ->join(
            'sys_role_menu_permissions',
            'sys_user_roles.role_id',
            '=',
            'sys_role_menu_permissions.role_id'
        )
        ->where('sys_user_roles.user_id', $user->id)
        ->where('sys_role_menu_permissions.menu_id', $menu->id)
        ->where("sys_role_menu_permissions.$column", 1)
        ->exists();
}
