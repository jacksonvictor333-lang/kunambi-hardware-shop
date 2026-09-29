<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display all users.
     */
    public function index()
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show create user form.
     */
    public function create()
    {
        $roles = Role::where('is_active', true)
            ->orderBy('display_name')
            ->get();

        return view('users.create', compact('roles'));
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role_id' => [
                'required',
                'exists:roles,id',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'],
        ]);

        $user->roles()->sync([
            $validated['role_id'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show edit user form.
     */
    public function edit(User $user)
    {
        $user->load('roles');

        $roles = Role::where('is_active', true)
            ->orderBy('display_name')
            ->get();

        $currentRole = $user->roles->first();

        return view('users.edit', compact(
            'user',
            'roles',
            'currentRole'
        ));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'role_id' => [
                'required',
                'exists:roles,id',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'],
        ]);

        $user->roles()->sync([
            $validated['role_id'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Activate user.
     */
    public function activate(User $user)
    {
        $user->update([
            'status' => 'active',
        ]);

        return back()->with(
            'success',
            'User activated successfully.'
        );
    }

    /**
     * Deactivate user.
     */
    public function deactivate(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'You cannot deactivate your own account.'
            );
        }

        $user->update([
            'status' => 'inactive',
        ]);

        return back()->with(
            'success',
            'User deactivated successfully.'
        );
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'You cannot delete your own account.'
            );
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}