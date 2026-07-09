<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        // Attempt authentication
        if (Auth::attempt($validated)) {
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')
                ->with('success', 'You have successfully logged in!');
        }

        // Authentication failed
        throw ValidationException::withMessages([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle user logout.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'You have been logged out successfully.');
    }
}
