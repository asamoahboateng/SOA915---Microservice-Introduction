<?php

namespace App\Http\Controllers;

use App\Models\ArrayUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticateUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);
        /*
        * api post request to /api/user/verify
         * is status is 401, then return error
         * if status is 200, create a session key with user and login
        */
        $baseUrl = env('AUTH_API_BASE_URL', 'http://localhost:8000');
        $endpoint = $baseUrl . '/api/user/verify';
        $response = Http::withOptions(['verify' => false, 'timeout' => '30'])->asForm()->post($endpoint, [
            'username' => $request->input('username'),
            'passcode' => $request->input('password'),
        ]);

        if ($response->status() === 401) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }

        if ($response->status() === 200) {
            $userData = $response->json()['user_data'];

            // Store user data in session
            $request->session()->put('user', $userData);
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);


        $credentials = $request->only('email', 'password');

        if (true) {
//        if (auth()->attempt($credentials)) {
            $user = new ArrayUser([
                'id' => '12',
                'username' => 'kwame',
                'name' => 'Kwame log',
                // Add other fields as needed
            ]);

            // Login the user
            Auth::login($user);
            $request->session()->regenerate();

            dd(auth()->user());
            return redirect()->intended('dashboard');
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');

            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }
}
