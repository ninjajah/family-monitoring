<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return Inertia::render('Admin/Roles/Index', compact('roles'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return Inertia::render('Admin/Roles/Permissions', [
            'role' => $role->load('permissions'),
            'permissions' => $permissions,
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions);

        return back()->with('success', 'Разрешения обновлены');
    }
}
