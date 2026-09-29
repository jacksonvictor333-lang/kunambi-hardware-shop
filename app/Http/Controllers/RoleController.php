<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display all roles.
     */
    public function index()
    {
        $roles = Role::withCount('users', 'permissions')
            ->orderBy('display_name')
            ->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show create role form.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a new role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',
                'unique:roles,name',
            ],
            'display_name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        Role::create($validated);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show edit role form.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update an existing role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('roles', 'name')
                    ->ignore($role->id),
            ],
            'display_name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $role->update($validated);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Delete a role.
     */
    public function destroy(Role $role)
    {
        /*
        |--------------------------------------------------------------------------
        | Protect roles that are currently assigned to users
        |--------------------------------------------------------------------------
        */

        if ($role->users()->exists()) {
            return back()->with(
                'error',
                'This role cannot be deleted because it is assigned to one or more users.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove permission assignments
        |--------------------------------------------------------------------------
        */

        $role->permissions()->detach();

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}