<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\StrHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    public function showRegistrationForm(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request): RedirectResponse
    {
        if ($request->has('phone')) {
            $request->merge([
                'phone' => StrHelper::normalizePhone($request->phone),
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'regex:/^09[0-9]{9}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'نام و نام‌خانوادگی الزامی است.',
            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'لطفاً یک آدرس ایمیل معتبر وارد کنید.',
            'email.unique' => 'این ایمیل قبلاً ثبت نام کرده است.',
            'phone.required' => 'شماره موبایل الزامی است.',
            'phone.regex' => 'فرمت شماره موبایل نامعتبر است (مثال: 09123456789).',
            'phone.unique' => 'این شماره موبایل قبلاً در سیستم ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.confirmed' => 'تکرار رمز عبور با رمز عبور مطابقت ندارد.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect(route('dashboard'))->with('success', 'حساب کاربری شما با موفقیت ایجاد شد. خوش آمدید!');
    }
}
