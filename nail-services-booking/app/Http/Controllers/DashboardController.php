<?php

namespace App\Http\Controllers;

use App\Models\ArrayUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index()
    {
//        dd(session()->get('user'));
        return view('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        session()->forget('user');
        return redirect()->route('login');
    }
}
