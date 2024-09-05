<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            flash()->addSuccess('Welcome to Domain Host Hub');
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');


        $check = User::where('email', $request->email)->first();
        if(isset($check)){
            if($check->status == 1){
                if (Auth::guard('web')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Domain Host Hub');
                    return redirect()->route('admin.dashboard');
                }
                flash()->addError('Invalid credentials');
            }else{
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        }else{
            flash()->addError('Data Not Found');
        }
        return redirect()->route('login');
    }



    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');

    }
}
