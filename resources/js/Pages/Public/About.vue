<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  Sparkles, 
  Target, 
  Rocket, 
  ShieldCheck, 
  Award, 
  Users2, 
  CheckCircle2, 
  ArrowLeft, 
  Zap, 
  Code2 
} from 'lucide-vue-next';
</script>

<template>
  <Head title="درباره ما | آژانس مهندسی وب سلمیر" />
  
  <PublicLayout>
    <!-- Header Hero -->
    <div class="relative py-24 bg-radial-glow bg-dot-pattern border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-100/80 text-blue-700 text-xs font-bold mb-4">
          <Sparkles class="w-4 h-4" />
          <span>هویت و داستان سلمیر</span>
        </div>
        <h1 class="text-4xl sm:text-6xl font-black text-slate-900 mb-6 tracking-tight">
          تلفیق هنر دیزاین و مهندسی نرم‌افزار
        </h1>
        <p class="text-base sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
          ما در سلمیر صرفاً کد نمی‌زنیم؛ ما پلتفرم‌هایی خلق می‌کنیم که کسب‌وکار شما را متمایز، سریع و آماده رقابت جهانی می‌کند.
        </p>
      </div>
    </div>

    <!-- Story & Mission -->
    <div class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          
          <div class="space-y-6">
            <div class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">
              <Target class="w-4 h-4" />
              <span>ماموریت ما</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 leading-snug">
              ایجاد استانداردی نوین در توسعه وب با حذف پیچیدگی‌های سنتی
            </h2>
            <div class="space-y-4 text-slate-600 text-sm sm:text-base leading-relaxed">
              <p>
                آژانس سلمیر با این دیدگاه تاسیس شد که کسب‌وکارهای مدرن به چیزی فراتر از قالب‌های آماده و کدهای سنگین نیاز دارند. مشتریان امروز، انتظار سایتی را دارند که در کسری از ثانیه لود شود، رابط کاربری لوکس و بدون نقصی داشته باشد و در عین حال امن و مقیاس‌پذیر باشد.
              </p>
              <p>
                ما با بهره‌گیری از قدرتمندترین ابزارهای اکوسیستم وب نظیر فریم‌ورک Laravel 12 در بک‌اند و Vue 3 + Inertia در فرانت‌اند، تجربه‌ای خلق می‌کنیم که حس یک اپلیکیشن بومی و روان را به کاربر نهایی القا می‌نماید.
              </p>
            </div>

            <div class="pt-4 grid grid-cols-2 gap-4">
              <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="text-3xl font-black text-blue-600 mb-1">۱۰۰+</div>
                <div class="text-xs text-slate-500 font-bold">پروژه موفق پیاده‌سازی‌شده</div>
              </div>
              <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="text-3xl font-black text-indigo-600 mb-1">۹۹.۸٪</div>
                <div class="text-xs text-slate-500 font-bold">رضایت کارفرمایان و شرکا</div>
              </div>
            </div>
          </div>

          <!-- Graphic Showcase Box -->
          <div class="rounded-3xl bg-gradient-to-tr from-slate-900 via-blue-950 to-indigo-900 p-8 sm:p-12 text-white relative shadow-2xl overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
              <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                <Rocket class="w-6 h-6" />
              </div>
              <h3 class="text-2xl font-bold">چرا سلمیر انتخابی متفاوت است؟</h3>
              
              <ul class="space-y-4 text-sm text-slate-300">
                <li class="flex items-start gap-3">
                  <CheckCircle2 class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" />
                  <span>توسعه کاملاً اختصاصی بدون استفاده از قالب‌های آماده و نال‌شده</span>
                </li>
                <li class="flex items-start gap-3">
                  <CheckCircle2 class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" />
                  <span>سیستم اختصاصی پیگیری سفارش و تیکت پشتیبانی ۲۴/۷</span>
                </li>
                <li class="flex items-start gap-3">
                  <CheckCircle2 class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" />
                  <span>کدنویسی تمیز با قابلیت مقیاس‌پذیری برای جذب هزاران کاربر همزمان</span>
                </li>
                <li class="flex items-start gap-3">
                  <CheckCircle2 class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" />
                  <span>مشاوره و انتقال دانش کامل پس از اتمام پروژه</span>
                </li>
              </ul>

              <div class="pt-4 border-t border-white/10">
                <Link 
                  :href="route('orders.create')" 
                  class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-blue-900 font-black text-sm hover:bg-blue-50 transition"
                >
                  <span>شروع همکاری با تیم سلمیر</span>
                  <ArrowLeft class="w-4 h-4" />
                </Link>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Core Values -->
    <div class="py-20 bg-slate-50 border-t border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <div class="mb-14">
          <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">ستون‌های موفقیت ما</span>
          <h2 class="text-3xl font-black text-slate-900 mt-2 mb-3">اصول و ارزش‌های کاری سلمیر</h2>
          <p class="text-slate-600 text-sm">تعهداتی که در تک‌تک خطوط کد و طراحی‌هایمان جاری است</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs hover:shadow-xl transition">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-6">
              <Zap class="w-7 h-7" />
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">سرعت و پرفورمنس بی‌رحمانه</h3>
            <p class="text-slate-600 text-sm leading-relaxed">
              ما هیچ کسر ثانیه‌ای را تلف نمی‌کنیم؛ تمام انیمیشن‌ها، استایل‌ها و کوئری‌های دیتابیس در بالاترین سطح بهینه‌سازی می‌شوند.
            </p>
          </div>

          <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs hover:shadow-xl transition">
            <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mx-auto mb-6">
              <ShieldCheck class="w-7 h-7" />
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">امنیت و پایداری سازمانی</h3>
            <p class="text-slate-600 text-sm leading-relaxed">
              تضمین حفاظت از داده‌های کاربران، محافظت در برابر حملات سایبری و بکاپ‌گیری‌های منظم زیرساخت شما.
            </p>
          </div>

          <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs hover:shadow-xl transition">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-6">
              <Users2 class="w-7 h-7" />
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">همراهی و شفافیت کامل</h3>
            <p class="text-slate-600 text-sm leading-relaxed">
              گزارش‌دهی شفاف در تمام مراحل پروژه و سیستم پشتیبانی مستقیم از طریق تیکتینگ برای آرامش خاطر شما.
            </p>
          </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>