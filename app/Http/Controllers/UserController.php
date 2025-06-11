<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return Inertia::render('Admin/Users/Index',
            [
                'users' => $users,
                'roles' => $roles,
            ]
        );
    }

    public function create()
    {
        $roles = Role::all();

        return Inertia::render('Admin/Users/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь успешно создан');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return Inertia::render('Admin/Users/Edit', [
            'user' => $user->load('roles'),
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'roles' => 'array',
        ]);

        $user->update($validated);
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'Пользователь обновлен');
    }

    public function destroy(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return redirect()->back()
                    ->with('error', 'Вы не можете удалить свой собственный аккаунт');
            }

            $user->delete();

            return redirect()->back()
                ->with('success', 'Пользователь успешно удалён');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении пользователя');
        }
    }
}
