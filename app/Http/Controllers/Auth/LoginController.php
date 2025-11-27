<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog; // 👈 ADD THIS LINE

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        // 👈 ADD LOGIN LOG HERE
        UserLog::create([
            'user_id' => auth()->id(),
            'action' => 'login',
            'ip' => $request->ip(), // Use $request->ip()
            'user_agent' => $request->userAgent() // Use $request->userAgent()
        ]);
        // 👆 END LOGIN LOG

        return redirect()->route('dashboard');
    }

    /**
     * Log the user out of the application.
     * * You will need to make sure this method is registered as a route (e.g., 'logout').
     */
    public function logout(Request $request)
    {
        // 👈 ADD LOGOUT LOG BEFORE LOGGING OUT
        UserLog::create([
            'user_id' => auth()->id(),
            'action' => 'logout',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        // 👆 END LOGOUT LOG

        Auth::logout(); // Use the Auth facade to log the user out

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/'); // Redirect to the home page or login page
    }
}