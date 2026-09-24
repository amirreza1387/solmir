<script setup>
import { Link } from '@inertiajs/vue3';
import { 
  Sparkles, 
  Mail, 
  Phone, 
  MapPin, 
  ArrowUpRight, 
  ShieldCheck, 
  Clock, 
  CheckCircle2 
} from 'lucide-vue-next';
</script>

<template>
  <footer class="bg-slate-950 text-slate-300 pt-16 pb-10 border-t border-slate-800/80 relative overflow-hidden">
    <!-- Ambient glow in footer -->
    <div class="absolute -top-32 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 pb-12 border-b border-slate-800/80">
        
        <!-- Brand Info (2 cols on lg) -->
        <div class="lg:col-span-2 space-y-5">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
              <Sparkles class="w-5 h-5" />
            </div>
            <span class="text-2xl font-black tracking-tight text-white">
              سلمیر
            </span>
          </div>

          <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
            آژانس مهندسی وب و نوآوری دیجیتال سلمیر؛ ما وب‌سایت‌ها و پلتفرم‌های سفارشی با بالاترین استاندارد سرعت، امنیت و طراحی خلق می‌کنیم تا برند شما متمایز شود.
          </p>

          <div class="flex items-center gap-3 text-xs text-slate-400 bg-slate-900/80 border border-slate-800 p-3 rounded-xl max-w-sm">
            <ShieldCheck class="w-5 h-5 text-blue-400 shrink-0" />
            <span>ضمانت کیفیت، پشتیبانی فعال و قرارداد رسمی برای تمامی پروژه‌ها</span>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-white font-bold text-base mb-4 flex items-center gap-2">
            <span>دسترسی سریع</span>
          </h4>
          <ul class="space-y-2.5 text-sm">
            <li>
              <Link href="/" class="hover:text-blue-400 transition-colors flex items-center gap-1.5">
                <span>صفحه اصلی</span>
              </Link>
            </li>
            <li>
              <Link href="/services" class="hover:text-blue-400 transition-colors flex items-center gap-1.5">
                <span>خدمات و پکیج‌ها</span>
              </Link>
            </li>
            <li>
              <Link href="/portfolio" class="hover:text-blue-400 transition-colors flex items-center gap-1.5">
                <span>نمونه‌کارها و پروژه‌ها</span>
              </Link>
            </li>
            <li>
              <Link href="/about" class="hover:text-blue-400 transition-colors flex items-center gap-1.5">
                <span>درباره تیم سلمیر</span>
              </Link>
            </li>
            <li>
              <Link href="/contact" class="hover:text-blue-400 transition-colors flex items-center gap-1.5">
                <span>تماس و مشاوره رایگان</span>
              </Link>
            </li>
          </ul>
        </div>

        <!-- Services -->
        <div>
          <h4 class="text-white font-bold text-base mb-4">
            خدمات تخصصی
          </h4>
          <ul class="space-y-2.5 text-sm text-slate-400">
            <li class="hover:text-blue-400 transition cursor-pointer">طراحی وب‌سایت شرکتی و فروشگاهی</li>
            <li class="hover:text-blue-400 transition cursor-pointer">طراحی اختصاصی UI/UX مدرن</li>
            <li class="hover:text-blue-400 transition cursor-pointer">بهینه‌سازی سرعت و سئو تخصصی</li>
            <li class="hover:text-blue-400 transition cursor-pointer">توسعه پنل‌ها و پلتفرم‌های تحت وب</li>
            <li class="hover:text-blue-400 transition cursor-pointer">پشتیبانی و نگهداری نرم‌افزاری</li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 class="text-white font-bold text-base mb-4">
            ارتباط با ما
          </h4>
          <ul class="space-y-3 text-sm">
            <li class="flex items-start gap-2.5">
              <Phone class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" />
              <div class="flex flex-col">
                <span class="text-slate-400 text-xs">تماس مستقیم:</span>
                <span class="text-white font-mono font-medium dir-ltr text-right">۰۲۱-۸۸۹۹۰۰۱۱</span>
              </div>
            </li>
            <li class="flex items-start gap-2.5">
              <Mail class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" />
              <div class="flex flex-col">
                <span class="text-slate-400 text-xs">ایمیل پشتیبانی:</span>
                <span class="text-white font-mono font-medium">info@solmir.com</span>
              </div>
            </li>
            <li class="flex items-start gap-2.5">
              <Clock class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" />
              <span class="text-slate-400 text-xs leading-relaxed">شنبه تا چهارشنبه ۹ الی ۱۸ | پشتیبانی تیکتینگ ۲۴/۷</span>
            </li>
          </ul>
        </div>

      </div>

      <!-- Copyright & Bottom Bar -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
        <p>© {{ new Date().getFullYear() }} تمامی حقوق برای آژانس طراحی وب سلمیر (Solmir) محفوظ است.</p>
        <div class="flex items-center gap-6">
          <Link href="/about" class="hover:text-slate-400 transition">قوانین و حریم خصوصی</Link>
          <Link href="/contact" class="hover:text-slate-400 transition">پشتیبانی و استعلام</Link>
          <span class="text-emerald-400 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            وضعیت سرورها: آنلاین و پایدار
          </span>
        </div>
      </div>
    </div>
  </footer>
</template>
