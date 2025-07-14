<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
   public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
         $validator = Validator::make(request()->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
         if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            if(auth()->user()->status == 0){
                Auth::logout();
                  return back()->withErrors([
                        'user' => 'User tidak valid atau sedang ditangguhkan.',
                    ])->withInput();
            }
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'username' => 'Kredensial tidak valid.',
        ])->withInput();
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
