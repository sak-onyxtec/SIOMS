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
        $request->authenticate();

        $request->session()->regenerate();
        
        $user = $request->user();
        
        // Check if staff user needs to change password on first login
        if ($user->hasRole('staff') && $user->first_login) {
            return redirect()->route('dashboard')->with('first_login', true);
        }
        
        return redirect()->route(
            $user->hasRole('customer') ? 'home.web' : 'dashboard'
        );
        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Decide where to redirect BEFORE logging out
        if ($user && method_exists($user, 'hasRole') && $user->hasRole('customer')) {
            $redirectTo = route('home.web');
        } else {
            // Admins and other roles go back to the auth login
            $redirectTo = route('login');
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($redirectTo);
    }
}
