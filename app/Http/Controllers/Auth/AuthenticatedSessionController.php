<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema; // ✅ Added for table existence check
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View|RedirectResponse
    {
        $adminExists = false;

        try {
            // ✅ Only run query if the 'users' table exists
            if (Schema::hasTable('users')) {
                $adminExists = User::where('role', 'admin')->exists();

                // ✅ Optional: Redirect to admin registration if no admin yet
                if (!$adminExists) {
                    return redirect()->route('admin.register');
                }
            }
        } catch (\Exception $e) {
            // ✅ Log the error so it doesn't crash the page
            \Log::error('Error checking admin existence: ' . $e->getMessage());
        }

        // ✅ Load login view safely even if DB not ready
        return view('auth.login', compact('adminExists'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,accountant,plumber,customer'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = auth()->user();

            // ✅ Check if user account is active
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending approval. Please wait for admin approval.',
                ]);
            }

            // ✅ Check if the selected role matches the user’s role
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Invalid role selected. Please select the correct role for your account.',
                ]);
            }

            // ✅ Redirect user by role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'));
                case 'accountant':
                    return redirect()->intended(route('accountant.dashboard'));
                case 'plumber':
                    return redirect()->intended(route('plumber.dashboard'));
                case 'customer':
                    return redirect()->intended(route('customer.dashboard'));
                default:
                    return redirect()->intended(route('dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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
