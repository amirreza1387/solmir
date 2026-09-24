<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  Laptop, 
  Palette, 
  Search, 
  Smartphone, 
  Headphones, 
  Code2, 
  ArrowLeft, 
  CheckCircle2, 
  Sparkles, 
  ShieldCheck, 
  Zap, 
  Clock 
} from 'lucide-vue-next';

const props = defineProps({
  services: {
    type: Array,
    default: () => []
  },
});

const searchQuery = ref('');
const activeCategory = ref('all');

const filteredServices = computed(() => {
  return props.services.filter(s => {
    const matchesSearch = s.title.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
                          s.description.toLowerCase().includes(searchQuery.value.toLowerCase());
    return matchesSearch;
  });
});

const getServiceIcon = (index) => {
  const icons = [Laptop, Palette, Search, Smartphone, Headphones, Code2];
  return icons[index % icons.length];
};
</script>

<template>
  <Head title="خدمات مهندسی وب و طراحی دیجیتال | سلمیر" />
  
  <PublicLayout>
    <!-- Header Banner -->
    <div class="relative py-20 bg-radial-glow bg-dot-pattern border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-100/80 text-blue-700 text-xs font-bold mb-4">
          <Sparkles class="w-4 h-4" />
          <span>پکیج‌های جامع دیجیتال</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 mb-4">
          خدمات تخصصی آژانس سلمیر
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
          راهکارهای مهندسی‌شده و اختصاصی برای تبدیل ایده‌های شما به پلتفرم‌های سریع، امن و پربازده.
        </p>

        <!-- Search Bar -->
        <div class="max-w-md mx-auto mt-8 relative">
          <input 
            v-model="searchQuery"
            type="text" 
            placeholder="جستجو در بین خدمات ما..."
            class="w-full px-5 py-3.5 pr-11 rounded-2xl bg-white border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <Search class="w-5 h-5 text-slate-400 absolute right-3.5 top-1/2 -translate-y-1/2" />
        </div>
      </div>
    </div>

    <!-- Services Grid -->
    <div class="py-20 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div v-if="filteredServices.length === 0" class="text-center py-16 bg-white rounded-3xl border border-slate-200">
          <Search class="w-12 h-12 text-slate-300 mx-auto mb-3" />
          <h3 class="text-lg font-bold text-slate-700">موردی یافت نشد</h3>
          <p class="text-slate-500 text-sm mt-1">با عبارت جستجوی دیگری مجدداً تلاش کنید.</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="(service, idx) in filteredServices" 
            :key="service.id" 
            class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between group"
          >
            <div>
              <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center mb-6 shadow-md shadow-blue-500/20 group-hover:scale-110 transition duration-300">
                <component :is="getServiceIcon(idx)" class="w-8 h-8" />
              </div>
              <h3 class="text-2xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                {{ service.title }}
              </h3>
              <p class="text-slate-600 text-sm leading-relaxed mb-6">
                {{ service.description }}
              </p>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
              <Link 
                :href="route('services.show', service.slug)" 
                class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5"
              >
                <span>مشاهده مشخصات و تعرفه</span>
                <ArrowLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
              </Link>
              <Link 
                :href="route('orders.create')" 
                class="text-xs px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold transition"
              >
                سفارش مستقیم
              </Link>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Pricing Comparison Tiers -->
    <div class="py-20 bg-white border-t border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
          <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">پلن‌های استاندارد سلمیر</span>
          <h2 class="text-3xl font-black text-slate-900 mt-2 mb-3">پکیج‌های پیشنهادی متناسب با نیاز شما</h2>
          <p class="text-slate-600 text-sm">از پروژه‌های شخصی و استارتاپی تا پلتفرم‌های جامع سازمانی</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          
          <!-- Tier 1 -->
          <div class="rounded-3xl p-8 border border-slate-200 bg-white flex flex-col justify-between hover:shadow-xl transition">
            <div>
              <div class="text-sm font-bold text-slate-500 mb-2">استارتاپ و شرکتی</div>
              <h3 class="text-2xl font-black text-slate-900 mb-4">پکیج پایه</h3>
              <div class="text-3xl font-black text-slate-900 mb-6">
                ۱۵ الی ۲۵ <span class="text-xs font-normal text-slate-500">میلیون تومان</span>
              </div>
              <ul class="space-y-3 text-sm text-slate-600 mb-8">
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> طراحی تا ۷ صفحه اختصاصی</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> ریسپانسیو ۱۰۰٪ موبایل و تبلت</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> بهینه‌سازی سرعت و متاتگ‌های سئو</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> ۲ ماه پشتیبانی فنی رایگان</li>
              </ul>
            </div>
            <Link :href="route('orders.create')" class="w-full py-3.5 rounded-xl border border-blue-600 text-blue-600 hover:bg-blue-50 font-bold text-center transition">
              انتخاب این پکیج
            </Link>
          </div>

          <!-- Tier 2 (Highlighted) -->
          <div class="rounded-3xl p-8 border-2 border-blue-600 bg-blue-50/40 relative shadow-xl flex flex-col justify-between">
            <span class="absolute -top-3.5 right-8 px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold">محبوب‌ترین انتخاب</span>
            <div>
              <div class="text-sm font-bold text-blue-600 mb-2">کسب‌وکارهای در حال رشد</div>
              <h3 class="text-2xl font-black text-slate-900 mb-4">پکیج حرفه‌ای Pro</h3>
              <div class="text-3xl font-black text-blue-700 mb-6">
                ۲۵ الی ۴۵ <span class="text-xs font-normal text-slate-600">میلیون تومان</span>
              </div>
              <ul class="space-y-3 text-sm text-slate-700 mb-8">
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-blue-600 shrink-0" /> تمام امکانات پکیج پایه</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-blue-600 shrink-0" /> پنل مدیریت اختصاصی و فارسی</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-blue-600 shrink-0" /> اتصال به درگاه پرداخت و درگاه پیامک</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-blue-600 shrink-0" /> سیستم تیکتینگ و پشتیبانی مشتریان</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-blue-600 shrink-0" /> ۶ ماه پشتیبانی فنی و امنیتی VIP</li>
              </ul>
            </div>
            <Link :href="route('orders.create')" class="w-full py-3.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 font-bold text-center shadow-md transition">
              ثبت سفارش حرفه‌ای
            </Link>
          </div>

          <!-- Tier 3 -->
          <div class="rounded-3xl p-8 border border-slate-200 bg-white flex flex-col justify-between hover:shadow-xl transition">
            <div>
              <div class="text-sm font-bold text-slate-500 mb-2">سازمانی و پلتفرم‌ها</div>
              <h3 class="text-2xl font-black text-slate-900 mb-4">پکیج سازمانی Enterprise</h3>
              <div class="text-3xl font-black text-slate-900 mb-6">
                بر اساس نیازسنجی
              </div>
              <ul class="space-y-3 text-sm text-slate-600 mb-8">
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> معماری سفارشی با قابلیت هندل ترافیک بالا</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> پشتیبانی از اپلیکیشن موبایل PWA / Native</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> امنیت چندسطحی و لاگین ۲ عاملی</li>
                <li class="flex items-center gap-2"><CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" /> ۱ سال پشتیبانی و مشاوره مداوم</li>
              </ul>
            </div>
            <Link href="/contact" class="w-full py-3.5 rounded-xl border border-slate-300 text-slate-800 hover:bg-slate-50 font-bold text-center transition">
              درخواست جلسه مشاوره
            </Link>
          </div>

        </div>

      </div>
    </div>
  </PublicLayout>
</template>