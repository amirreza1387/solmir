<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('email', 'admin@solmir.com')->doesntExist()) {
            User::create([
                'name' => 'مدیر سیستم',
                'email' => 'admin@solmir.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        $services = [
            ['title' => 'طراحی وب‌سایت', 'slug' => 'web-design', 'description' => 'طراحی و توسعه وب‌سایت‌های مدرن و واکنش‌گرا با استفاده از جدیدترین تکنولوژی‌ها.'],
            ['title' => 'طراحی رابط کاربری (UI/UX)', 'slug' => 'ui-ux-design', 'description' => 'طراحی رابط کاربری جذاب و تجربه کاربری بهینه برای اپلیکیشن‌ها و وب‌سایت‌ها.'],
            ['title' => 'بهینه‌سازی موتورهای جستجو (SEO)', 'slug' => 'seo', 'description' => 'بهبود رتبه وب‌سایت شما در نتایج گوگل و افزایش بازدید ارگانیک.'],
            ['title' => 'توسعه اپلیکیشن موبایل', 'slug' => 'mobile-app', 'description' => 'طراحی و ساخت اپلیکیشن‌های موبایل برای پلتفرم‌های اندروید و iOS.'],
            ['title' => 'پشتیبانی و نگهداری', 'slug' => 'support', 'description' => 'پشتیبانی فنی و نگهداری مستمر از وب‌سایت و سیستم‌های شما.'],
            ['title' => 'برندینگ دیجیتال', 'slug' => 'branding', 'description' => 'هویت بصری یکپارچه و استراتژی برندینگ در فضای دیجیتال.'],
        ];

        foreach ($services as $index => $service) {
            Service::firstOrCreate(
                ['slug' => $service['slug']],
                array_merge($service, ['sort_order' => $index, 'is_active' => true])
            );
        }

        if (Portfolio::count() < 6) {
            Portfolio::factory(6)->create(['is_featured' => true]);
        }

        if (Testimonial::count() < 4) {
            Testimonial::factory(4)->create();
        }
    }
}
