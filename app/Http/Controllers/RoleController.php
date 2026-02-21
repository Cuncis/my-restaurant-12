<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->latest()->get();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|in:Admin,Cashier,Chef,Customer|unique:roles,name',
            'description' => 'required|string|max:500',
        ]);

        Role::create($request->only('name', 'description'));

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $role = Role::withCount('users')->findOrFail($id);
        return view('admin.role.show', compact('role'));
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|in:Admin,Cashier,Chef,Customer|unique:roles,name,' . $role->id,
            'description' => 'required|string|max:500',
        ]);

        $role->update($request->only('name', 'description'));

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $role = Role::withCount('users')->findOrFail($id);

        if ($role->users_count > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak dapat dihapus karena masih memiliki ' . $role->users_count . ' pengguna.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}

