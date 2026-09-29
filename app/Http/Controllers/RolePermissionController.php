<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display permissions for a specific role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::query()
            ->orderBy('module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('module');

        $role->load('permissions');

        $assignedPermissionIds = $role->permissions
            ->pluck('id')
            ->toArray();

        return view('roles.permissions', compact(
            'role',
            'permissions',
            'assignedPermissionIds'
        ));
    }

    /**
     * Update permissions assigned to a role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],
        ]);

        $permissionIds = $validated['permissions'] ?? [];

        $role->permissions()->sync($permissionIds);

        return redirect()
            ->route('roles.permissions.edit', $role)
            ->with('success', 'Role permissions updated successfully.');
    }
}