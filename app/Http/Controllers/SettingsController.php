<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    // MENU

    public function menu()
    {
        $data = [
            'title' => 'Membership Fees',
            'canCreate' => has_permission('settings.menu', 'create'),
            'canEdit' => has_permission('settings.menu', 'edit'),
            'canDelete' => has_permission('settings.menu', 'delete'),
            'remark' => ''
        ];
        return view('settings.menu', $data);
    }

    public function getDataMenu(Request $request)
    {
        $data = DB::table('sys_menus')
            ->select('*');


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('menu_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('id', 'asc')->get();
        return response()->json($data);
    }

    public function CrudMenu(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'menu_name'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'menu_url'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'sort_no'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];
        $message = '';

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'menu_name' => $request->menu_name,
            'menu_url' => $request->menu_url,
            'menu_icon' => $request->menu_icon,
            'parent_id' => $request->parent_id,
            'column_no' => $request->column_no,
            'is_active' => $request->is_active,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('sys_menus')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('sys_menus')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':

                    DB::table('sys_menus')->where('id', $request->id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function DataIcons(Request $request)
    {
        $search = $request->term ?? '';

        $page = $request->page ?? 1;
        $limit = 30;
        $query = DB::table('sys_icon');
        if ($search) {
            $query->where('icon_name', 'like', "%{$search}%")
                ->orWhere('icon_class', 'like', "%{$search}%");
        }
        $total = $query->count();
        $icons = $query
            ->orderBy('id', 'asc')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return response()->json([
            'results' => $icons->map(function ($item) {
                return [
                    'id' => $item->icon_class,
                    'text' => $item->icon_name,
                    'icon_class' => $item->icon_class,
                ];
            }),
            'pagination' => [
                'more' => ($page * $limit) < $total
            ]
        ]);
    }

    // ROLE & PERMISSIONS
    public function roles()
    {
        $data = [
            'title' => 'Membership Fees',
            'canCreate' => has_permission('settings.menu', 'create'),
            'canEdit' => has_permission('settings.menu', 'edit'),
            'canDelete' => has_permission('settings.menu', 'delete'),
            'remark' => ''
        ];
        return view('settings.roles', $data);
    }

    public function getDataRoles(Request $request)
    {
        $data = DB::table('sys_roles')
            ->select('*');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('role_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('id', 'asc')->get();
        return response()->json($data);
    }

    public function MenuPermissions(Request $request)
    {
        switch ($request->formAction) {
            case "create":
                // $menus = Menu::get();
                $data = DB::table('sys_menus as a')
                    ->select(
                        'a.*',
                        'a.id as menu_id'
                    )
                    ->orderBy('a.id')
                    ->orderBy('a.parent_id')
                    ->orderBy('a.menu_name')
                    ->get();
                $data = $this->buildMenuTree($data);
                break;
            default:
                $menus = DB::table('sys_role_menu_permissions as a')
                    ->leftJoin('sys_menus as b', 'b.id', '=', 'a.menu_id')
                    ->select(
                        'a.*',
                        'b.menu_name',
                        'b.parent_id',
                        'b.menu_icon'
                    )
                    ->where('a.role_id', $request->id)
                    ->orderBy('b.id')
                    ->orderBy('b.parent_id')
                    ->orderBy('b.menu_name')
                    ->get();

                if ($menus->count() <= 0) {
                    $menus = DB::table('sys_menus as a')
                        ->select(
                            'a.*',
                            'a.id as menu_id'
                        )
                        ->orderBy('a.id')
                        ->orderBy('a.parent_id')
                        ->orderBy('a.menu_name')
                        ->get();
                }

                $data = $this->buildMenuTree($menus);
                break;
        }
        return response()->json($data);
    }

    private function buildMenuTree($menus, $parentId = 0, $level = 0)
    {
        $result = [];
        foreach ($menus as $menu) {
            if ((int)$menu->parent_id === (int)$parentId) {
                $menu->level = $level;
                $result[] = $menu;
                $children = $this->buildMenuTree(
                    $menus,
                    $menu->menu_id,
                    $level + 1
                );
                $result = array_merge($result, $children);
            }
        }
        return $result;
    }

    public function CrudRoles(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'role_name' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'role_name' => $request->role_name,
            'is_active' => $request->is_active,
            'created_by'    => auth()->id() ?? 'system',
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    $roleId = DB::table('sys_roles')->insertGetId($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('sys_roles')->where('id', $request->id)->update($data);
                    $roleId = $request->id;
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('sys_role_menu_permissions')->where('role_id', $request->id)->delete();
                    DB::table('sys_roles')->where('id', $request->id)->delete();
                    $roleId = $request->id;
                    $message = 'Data berhasil dihapus';
                    break;
            }

            if ($request->action != 'delete') {
                // 🔥 Decode jika detail dikirim sebagai JSON string
                $permissions = $request->permissions;
                if (is_string($permissions)) {
                    $permissions = json_decode($permissions, true);
                }
                // 🔥 Proses permissions hanya jika ada data
                if (!empty($permissions) && is_array($permissions)) {
                    self::CrudMenuPermissions($permissions, $roleId);
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    private function CrudMenuPermissions($permissions, $roleId)
    {
        foreach ($permissions as $permit) {
            DB::table('sys_role_menu_permissions')
                ->updateOrInsert(
                    // WHERE
                    [
                        'role_id' => $roleId,
                        'menu_id' => $permit['menu_id'],
                    ],
                    // DATA UPDATE / INSERT
                    [
                        'can_view'   => !empty($permit['can_view']) ? 1 : 0,
                        'can_create' => !empty($permit['can_create']) ? 1 : 0,
                        'can_edit'   => !empty($permit['can_edit']) ? 1 : 0,
                        'can_delete' => !empty($permit['can_delete']) ? 1 : 0,
                    ]
                );
        }
    }


    // Setting Users 
    public function users()
    {
        $data = [
            'title' => 'Membership Fees',
            'canCreate' => has_permission('settings.menu', 'create'),
            'canEdit' => has_permission('settings.menu', 'edit'),
            'canDelete' => has_permission('settings.menu', 'delete'),
            'remark' => ''
        ];
        return view('settings.users', $data);
    }

    public function getDataUsers(Request $request)
    {
        $data = DB::table('sys_users as a')
            ->leftJoin('vw_employee as b', 'b.employee_id', 'a.employee_id')
            ->leftJoin('sys_user_roles as c', 'c.user_id', 'a.id')
            ->leftJoin('sys_roles as d', 'd.id', 'c.role_id')
            ->select('a.*', 'b.employee_code', 'c.role_id', 'd.role_name');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('name', 'like', '%' . $request->search . '%')->Orwhere('email', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('id', 'asc')->get();
        return response()->json($data);
    }

    public function CrudUsers(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'name' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'email' => !in_array($request->action, ['delete', 'update'])
                ? 'required|string|max:255|unique:sys_users,email'
                : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'created_by'    => auth()->id() ?? 'system',
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        if (!empty($request->password) && $request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('sys_users')->insertGetId($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('sys_users')->where('id', $request->id)->update($data);
                    // hapus semua role lama user
                    DB::table('sys_user_roles')
                        ->where('user_id', $request->id)
                        ->delete();

                    // insert role baru
                    DB::table('sys_user_roles')
                        ->insert([
                            'role_id' => $request->role_id,
                            'user_id' => $request->id
                        ]);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('sys_user_roles')
                        ->where('user_id', $request->id)
                        ->delete();
                    DB::table('sys_users')->where('id', $request->id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
