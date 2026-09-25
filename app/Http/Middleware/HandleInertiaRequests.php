<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'seo' => [
                'appName' => config('app.name', 'Solmir'),
                'appUrl' => rtrim(config('app.url', 'https://solmir.ir'), '/'),
                'brandName' => 'Solmir',
                'brandDescription' => 'آژانس طراحی وب و توسعه نرم‌افزار',
                'defaultDescription' => 'آژانس طراحی وب و مهندسی نرم‌افزار سلمیر؛ ارائه راهکارهای نوین دیجیتال، طراحی UI/UX و سیستم‌های تحت وب با بالاترین کیفیت مهندسی.',
                'phone' => '09179278747',
                'email' => 'solmirofc@gmail.com',
                'ogImage' => config('app.og_image') ? asset(config('app.og_image')) : null,
            ],
        ];
    }
}
