<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  ArrowLeft, 
  Sparkles, 
  CheckCircle2, 
  ShieldCheck, 
  Clock, 
  PlusCircle, 
  MessageSquare,
  Layers,
  Code2
} from 'lucide-vue-next';

defineProps({
  service: {
    type: Object,
    required: true,
  },
});

const workSteps = [
  { step: '۰۱', title: 'مشاوره و تحلیل نیازها', desc: 'بررسی دقیق حوزه فعالیت، اهداف تجاری و تحلیل رقبا' },
  { step: '۰۲', title: 'طراحی پروتوتایپ و UI/UX', desc: 'طراحی ساختار بصری، وایرفریم‌ها و پروتوتایپ تعاملی در فیگما' },
  { step: '۰۳', title: 'توسعه فنی و پیاده‌سازی', desc: 'کدنویسی تمیز با فریم‌ورک‌های مدرن و استانداردهای روز جهانی' },
  { step: '۰۴', title: 'تست کیفی و تحویل نهایی', desc: 'ارزیابی امنیتی، تست سرعت و استقرار روی سرور پروداکشن' },
];
</script>

<template>
  <Head :title="`${service.title} | خدمات تخصصی آژانس سلمیر`" />

  <PublicLayout>
    <div class="py-12 lg:py-20 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Link -->
        <Link 
          href="/services" 
          class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 mb-8 bg-white border border-slate-200 px-4 py-2 rounded-xl transition"
        >
          <ArrowLeft class="w-4 h-4 rotate-180" />
          <span>بازگشت به فهرست خدمات</span>
        </Link>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
          
          <!-- Main Content (2 cols) -->
          <div class="lg:col-span-2 space-y-8">
            
            <!-- Hero Card -->
            <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm relative overflow-hidden">
              <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center mb-6 shadow-md shadow-blue-500/20">
                <Layers class="w-8 h-8" />
              </div>

              <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold mb-4">
                <Sparkles class="w-3.5 h-3.5" />
                <span>خدمت تخصصی سلمیر</span>
              </div>

              <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-6 leading-tight">
                {{ service.title }}
              </h1>

              <div class="text-slate-700 leading-relaxed text-base sm:text-lg border-t border-slate-100 pt-6 whitespace-pre-wrap">
                {{ service.description }}
              </div>
            </div>


            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs space-y-6">
              <div class="flex items-center gap-2 pb-4 border-b border-slate-100">
                <Clock class="w-5 h-5 text-blue-600" />
                <h3 class="text-xl font-bold text-slate-900">روند معمول همکاری</h3>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div 
                  v-for="step in workSteps" 
                  :key="step.step"
                  class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2"
                >
                  <div class="flex items-center justify-between">
                    <span class="text-xs font-mono font-black text-blue-600 bg-blue-100/70 px-2.5 py-0.5 rounded-lg">{{ step.step }}</span>
                    <Code2 class="w-4 h-4 text-slate-300" />
                  </div>
                  <h4 class="font-bold text-sm text-slate-900">{{ step.title }}</h4>
                  <p class="text-xs text-slate-500 leading-relaxed">{{ step.desc }}</p>
                </div>
              </div>
            </div>

          </div>

          <!-- Sidebar Sticky CTA (1 col) -->
          <div class="space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm sticky top-28 space-y-6">
              <div class="text-center pb-6 border-b border-slate-100">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-2">شروع همکاری</span>
                <h3 class="text-xl font-black text-slate-900">سفارش {{ service.title }}</h3>
                <p class="text-xs text-slate-500 mt-2">جزئیات اجرا پس از بررسی نیازهای پروژه مشخص می‌شود.</p>
              </div>

              <div class="space-y-3">
                <Link 
                  :href="route('orders.create')" 
                  class="ui-button ui-button-primary w-full"
                >
                  <PlusCircle class="w-4 h-4" />
                  <span>ثبت آنلاین سفارش پروژه</span>
                </Link>

                <Link 
                  :href="route('contact.index')" 
                  class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition"
                >
                  <MessageSquare class="w-4 h-4 text-slate-500" />
                  <span>درخواست مشاوره رایگان</span>
                </Link>
              </div>

              <div class="pt-6 border-t border-slate-100 space-y-3 text-xs text-slate-600">
                <div class="flex items-center gap-2">
                  <ShieldCheck class="w-4 h-4 text-emerald-500 shrink-0" />
                  <span>عقد قرارداد رسمی و تعهد NDA</span>
                </div>
                <div class="flex items-center gap-2">
                  <CheckCircle2 class="w-4 h-4 text-blue-500 shrink-0" />
                  <span>تحویل سورس‌کد کامل پروژه</span>
                </div>
                <div class="flex items-center gap-2">
                  <Clock class="w-4 h-4 text-amber-500 shrink-0" />
                  <span>پیگیری درخواست‌ها از طریق پنل تیکت</span>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </PublicLayout>
</template>
