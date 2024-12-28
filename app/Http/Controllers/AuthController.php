<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUp()
    {
        return view('SignUp.user');
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:16|confirmed'
        ]);

        session([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('scientist.signUp');
    }

    public function showLoginForm()
    {
        return view('Login.login');
    }

    public function login(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Thử đăng nhập
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Ngăn chặn tấn công session fixation

            // Chuyển hướng đến trang Home hoặc dashboard
            return redirect()->intended('/home');
        }

        // Nếu đăng nhập thất bại
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không đúng.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.loginForm');
    }
}
