<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function showLoginForm()
    {
        if (Auth::guard('client')->check()) {
            flash()->addSuccess('Welcome ' . client()->name);
            return redirect()->route('cp.dashboard');
        }
        return view('client.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $check = Client::where('email', $request->email)->first();
        if (isset($check)) {
            if ($check->status == 1) {
                if (Auth::guard('client')->attempt($credentials)) {
                    flash()->addSuccess('Welcome ' . client()->name);
                    return redirect()->route('cp.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Data Not Found');
        }
        return redirect()->route('client.login');
    }



    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login');
    }
}