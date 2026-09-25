<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
  FileQuestion, 
  ShieldAlert, 
  Clock, 
  AlertTriangle, 
  ServerCrash, 
  Home, 
  ArrowRight,
  LayoutDashboard
} from 'lucide-vue-next';

const props = defineProps({
  status: {
    type: Number,
    required: true,
  },
});

const details = computed(() => {
  return {
    403: {
      title: 'دسترسی غیرمجاز',
      description: 'شما اجازه دسترسی به این بخش یا منبع مورد نظر را ندارید.',
      icon: ShieldAlert,
      badgeColor: 'bg-rose-100 text-rose-700',
    },
    404: {
      title: 'صفحه پیدا نشد',
      description: 'صفحه‌ای که به دنبال آن هستید حذف شده، تغییر نام یافته یا موقتاً در دسترس نیست.',
      icon: FileQuestion,
      badgeColor: 'bg-blue-100 text-blue-700',
    },
    419: {
      title: 'نشست کاربری منقضی شد',
      description: 'مدت زمان زیادی از آخرین فعالیت شما گذشته است. لطفاً صفحه را رفرش کرده و مجدداً تلاش کنید.',
      icon: Clock,
      badgeColor: 'bg-amber-100 text-amber-700',
    },
    429: {
      title: 'تعداد درخواست‌ها بیش از حد مجاز',
      description: 'درخواست‌های ارسالی شما بیش از سقف مجاز است. لطفاً چند لحظه صبر کنید و دوباره امتحان فرمایید.',
      icon: AlertTriangle,
      badgeColor: 'bg-orange-100 text-orange-700',
    },
    500: {
      title: 'خطای داخلی سرور',
      description: 'متاسفانه در پردازش درخواست شما مشکلی در سرور به وجود آمده است. تیم فنی در حال بررسی وضعیت است.',
      icon: ServerCrash,
      badgeColor: 'bg-red-100 text-red-700',
    },
    503: {
      title: 'سرویس در دسترس نیست',
      description: 'سایت در حال بروزرسانی یا نگهداری موقت است. به زودی در دسترس خواهیم بود.',
      icon: ServerCrash,
      badgeColor: 'bg-slate-100 text-slate-700',
    },
  }[props.status] || {
    title: 'خطایی رخ داده است',
    description: 'خطای پیش‌بینی‌نشده‌ای در پردازش درخواست شما رخ داد.',
    icon: AlertTriangle,
    badgeColor: 'bg-slate-100 text-slate-700',
  };
});

const goBack = () => {
  if (window.history.length > 1) {
    window.history.back();
  } else {
    window.location.href = '/';
  }
};
</script>

<template>
  <Head :title="`${status} - ${details.title} | سلمیر`" />

  <div class="min-h-screen bg-slate-50 flex flex-col justify-between p-6 sm:p-12 text-slate-800" dir="rtl">
    <!-- Top Brand -->
    <header class="max-w-4xl mx-auto w-full flex items-center justify-between">
      <Link href="/" class="flex items-center gap-3 group">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
          <span class="font-black text-lg">س</span>
        </div>
        <div class="text-xl font-black text-slate-900 group-hover:text-blue-600 transition">سلمیر</div>
      </Link>
    </header>

    <!-- Center Card -->
    <main class="max-w-lg mx-auto w-full my-auto py-12 text-center">
      <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-xl shadow-slate-200/50">
        
        <!-- Status Badge & Icon -->
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6 shadow-xs" :class="details.badgeColor">
          <component :is="details.icon" class="w-8 h-8" />
        </div>

        <div class="text-4xl sm:text-5xl font-black font-mono tracking-tight text-slate-900 mb-3">
          {{ status }}
        </div>

        <h1 class="text-xl sm:text-2xl font-black text-slate-900 mb-3">
          {{ details.title }}
        </h1>

        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-sm mx-auto mb-8">
          {{ details.description }}
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
          <button
            type="button"
            @click="goBack"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold transition shadow-xs cursor-pointer"
          >
            <ArrowRight class="w-4 h-4" />
            <span>بازگشت به صفحه قبل</span>
          </button>

          <Link
            href="/"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold transition shadow-md shadow-blue-500/20 cursor-pointer"
          >
            <Home class="w-4 h-4" />
            <span>صفحه اصلی وب‌سایت</span>
          </Link>
        </div>

      </div>
    </main>

    <!-- Footer -->
    <footer class="max-w-4xl mx-auto w-full text-center text-xs text-slate-400">
      پلتفرم و آژانس توسعه نرم‌افزار و طراحی وب سلمیر &copy;
    </footer>
  </div>
</template>
