<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\StrHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function showLoginForm(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'لطفاً ایمیل یا شماره موبایل خود را وارد کنید.',
            'password.required' => 'وارد کردن رمز عبور الزامی است.',
        ]);

        $input = StrHelper::normalizeDigits(trim($request->input('email')));
        $phoneInput = StrHelper::normalizePhone($input);

        $loginField = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $loginValue = $loginField === 'phone' ? $phoneInput : strtolower($input);

        $credentials = [
            $loginField => $loginValue,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'اطلاعات ورود (ایمیل/شماره یا رمز عبور) صحیح نمی‌باشد.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
