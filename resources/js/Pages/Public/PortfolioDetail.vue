<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  ArrowLeft, 
  ExternalLink, 
  Briefcase, 
  User, 
  Calendar, 
  CheckCircle2, 
  Sparkles, 
  Layers 
} from 'lucide-vue-next';

defineProps({
  portfolio: {
    type: Object,
    required: true
  },
});
</script>

<template>
  <Head :title="`${portfolio.title} | نمونه‌کار آژانس سلمیر`" />
  
  <PublicLayout>
    <div class="py-12 lg:py-20 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Link -->
        <Link 
          href="/portfolio" 
          class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 mb-8 bg-white border border-slate-200 px-4 py-2 rounded-xl transition"
        >
          <ArrowLeft class="w-4 h-4 rotate-180" />
          <span>بازگشت به گالری نمونه‌کارها</span>
        </Link>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
          
          <!-- Main Content (2 cols) -->
          <div class="lg:col-span-2 space-y-8">
            
            <!-- Project Image or Modern Mockup -->
            <div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-xl">
              <img 
                v-if="portfolio.image" 
                :src="'/storage/' + portfolio.image" 
                :alt="portfolio.title"
                class="w-full max-h-[500px] object-cover"
              />
              
              <!-- Futuristic Simulated Mockup Graphic -->
              <div v-else class="h-96 bg-gradient-to-tr from-slate-950 via-slate-900 to-blue-950 p-6 sm:p-10 flex flex-col justify-between text-white relative">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-400"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                  </div>
                  <span class="px-3 py-1 rounded-full bg-white/10 text-xs font-mono text-blue-200 backdrop-blur-md">
                    {{ portfolio.category }}
                  </span>
                </div>

                <div class="max-w-md mx-auto w-full bg-white/10 backdrop-blur-xl p-6 rounded-2xl border border-white/10 shadow-2xl text-center space-y-3">
                  <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center mx-auto shadow-md">
                    <Sparkles class="w-6 h-6" />
                  </div>
                  <h3 class="text-xl font-black text-white">{{ portfolio.title }}</h3>
                  <div class="text-xs text-blue-200 font-mono">طراحی و پیاده‌سازی مهندسی‌شده سلمیر</div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 font-mono">
                  <span>Verified Architecture</span>
                  <span>Core Web Vitals Passed</span>
                </div>
              </div>
            </div>

            <!-- Title & Description -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs space-y-6">
              <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1 block">{{ portfolio.category }}</span>
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900">{{ portfolio.title }}</h1>
              </div>

              <div class="border-t border-slate-100 pt-6">
                <h3 class="text-base font-bold text-slate-900 mb-4">شرح پروژه و اهداف اجرا:</h3>
                <p class="text-slate-700 leading-relaxed text-sm sm:text-base whitespace-pre-wrap">
                  {{ portfolio.description }}
                </p>
              </div>

              <!-- Technical Highlights -->
              <div class="border-t border-slate-100 pt-6">
                <h3 class="text-base font-bold text-slate-900 mb-4">ویژگی‌های فنی پیاده‌سازی‌شده:</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-700">
                  <div class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" />
                    <span>کدنویسی تمیز با Laravel و Vue 3</span>
                  </div>
                  <div class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" />
                    <span>لودینگ پرسرعت و بهینه‌سازی تصاویر</span>
                  </div>
                  <div class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" />
                    <span>طراحی رابط کاربری اختصاصی بر اساس هویت برند</span>
                  </div>
                  <div class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0" />
                    <span>سازگاری ۱۰۰٪ با انواع صفحات نمایش و تبلت</span>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Specs Sidebar (1 col) -->
          <div class="space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs space-y-6 sticky top-24">
              <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4">
                شناسنامه پروژه
              </h3>

              <div class="space-y-4 text-xs">
                <div class="flex items-start justify-between">
                  <span class="text-slate-400 flex items-center gap-1.5">
                    <Layers class="w-4 h-4 text-blue-600" />
                    دسته‌بندی:
                  </span>
                  <span class="font-bold text-slate-800">{{ portfolio.category }}</span>
                </div>

                <div v-if="portfolio.client_name" class="flex items-start justify-between">
                  <span class="text-slate-400 flex items-center gap-1.5">
                    <User class="w-4 h-4 text-blue-600" />
                    کارفرما / سازمان:
                  </span>
                  <span class="font-bold text-slate-800">{{ portfolio.client_name }}</span>
                </div>

                <div class="flex items-start justify-between">
                  <span class="text-slate-400 flex items-center gap-1.5">
                    <Calendar class="w-4 h-4 text-blue-600" />
                    تاریخ اجرا:
                  </span>
                  <span class="font-bold text-slate-800 font-mono">{{ new Date(portfolio.created_at).toLocaleDateString('fa-IR') }}</span>
                </div>
              </div>

              <!-- Live URL Button -->
              <div v-if="portfolio.url" class="pt-4 border-t border-slate-100">
                <a 
                  :href="portfolio.url" 
                  target="_blank" 
                  rel="noopener"
                  class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition"
                >
                  <ExternalLink class="w-4 h-4" />
                  <span>مشاهده وب‌سایت آنلاین</span>
                </a>
              </div>

              <!-- Start similar project CTA -->
              <div class="pt-4 border-t border-slate-100">
                <Link 
                  :href="route('orders.create')" 
                  class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-50 hover:bg-blue-50 text-blue-700 font-bold text-xs border border-slate-200 hover:border-blue-300 transition"
                >
                  <Sparkles class="w-4 h-4" />
                  <span>سفارش پروژه‌ای مشابه این کار</span>
                </Link>
              </div>

            </div>
          </div>

        </div>

      </div>
    </div>
  </PublicLayout>
</template>