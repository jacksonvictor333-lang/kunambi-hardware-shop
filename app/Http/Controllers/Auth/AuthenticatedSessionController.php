<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Authenticate User
        |--------------------------------------------------------------------------
        */
        $request->authenticate();

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */
        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Get Authenticated User
        |--------------------------------------------------------------------------
        */
        $user = Auth::guard('web')->user();

        /*
        |--------------------------------------------------------------------------
        | Check User Status
        |--------------------------------------------------------------------------
        |
        | Only active users are allowed to access the system.
        |
        */
        if (!$user || $user->status !== 'active') {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Your account has been deactivated. Please contact the administrator.',
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Administrator
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('administrator')) {
            return redirect()->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('manager')) {
            return redirect()->route('manager.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Sales Staff
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('sales_staff')) {
            return redirect()->route('sales.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Storekeeper
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('storekeeper')) {
            return redirect()->route('inventory.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Accountant
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('accountant')) {
            return redirect()->route('accountant.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | User Has No Valid Role
        |--------------------------------------------------------------------------
        */
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()
            ->withErrors([
                'email' => 'Your account does not have a valid role. Please contact the administrator.',
            ])
            ->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
