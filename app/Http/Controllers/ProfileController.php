<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\StrHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Dashboard/Profile', [
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'phone' => $request->user()->phone,
                'role' => $request->user()->role,
                'created_at' => $request->user()->created_at,
            ],
        ]);
    }

    /**
     * Update the user's personal profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->has('phone')) {
            $request->merge([
                'phone' => StrHelper::normalizePhone($request->phone),
            ]);
        }

        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^09[0-9]{9}$/',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ], [
            'name.required' => 'نام و نام‌خانوادگی الزامی است.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'email.required' => 'آدرس ایمیل الزامی است.',
            'email.email' => 'لطفاً یک آدرس ایمیل معتبر وارد کنید.',
            'email.unique' => 'این ایمیل قبلاً توسط کاربر دیگری ثبت شده است.',
            'phone.required' => 'شماره موبایل الزامی است.',
            'phone.regex' => 'فرمت شماره موبایل نامعتبر است (مثال: 09123456789).',
            'phone.unique' => 'این شماره موبایل قبلاً توسط کاربر دیگری ثبت شده است.',
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'اطلاعات کاربری شما با موفقیت بروزرسانی شد.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'وارد کردن کلمه عبور فعلی الزامی است.',
            'current_password.current_password' => 'کلمه عبور فعلی وارد شده نادرست است.',
            'password.required' => 'کلمه عبور جدید الزامی است.',
            'password.confirmed' => 'تکرار کلمه عبور با کلمه عبور جدید مطابقت ندارد.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('success', 'کلمه عبور شما با موفقیت تغییر یافت.');
    }
}
