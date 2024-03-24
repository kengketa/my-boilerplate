<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return Inertia::render('Dashboard/Role/Index')->with([
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $req = $request->validate([
            'name' => ['required']
        ]);
        Role::create([
            'name' => $req['name']
        ]);
        return redirect()->route('dashboard.roles.index');
    }

    public function create()
    {
        return Inertia::render('Dashboard/Role/Create');
    }

    public function edit(Role $role)
    {
        return Inertia::render('Dashboard/Role/Edit')->with([
            'role' => $role
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $req = $request->validate([
            'name' => ['required']
        ]);
        $role->name = $req['name'];
        $role->save();
        return redirect()->route('dashboard.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('dashboard.roles.index')->with('success', 'role deleted successfuly.');
    }
}
