<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
  ShoppingBag, 
  ArrowLeft, 
  Clock, 
  Calendar, 
  Coins, 
  FileText, 
  CheckCircle2, 
  ShieldCheck, 
  Paperclip,
  Download
} from 'lucide-vue-next';

const props = defineProps({
  order: {
    type: Object,
    required: true
  }
});

const getStatusBadge = (status) => {
  const map = {
    pending: { label: 'در انتظار بررسی اولیه', class: 'bg-amber-100 text-amber-800 border-amber-200' },
    confirmed: { label: 'تایید شده و آماده قرارداد', class: 'bg-blue-100 text-blue-800 border-blue-200' },
    in_progress: { label: 'در حال توسعه فنی', class: 'bg-indigo-100 text-indigo-800 border-indigo-200' },
    completed: { label: 'پروژه تکمیل و تحویل داده شد', class: 'bg-emerald-100 text-emerald-800 border-emerald-200' },
    cancelled: { label: 'سفارش لغو شده', class: 'bg-rose-100 text-rose-800 border-rose-200' }
  };
  return map[status] || { label: status, class: 'bg-slate-100 text-slate-800 border-slate-200' };
};

const getStepNumber = (status) => {
  if (status === 'pending') return 1;
  if (status === 'confirmed') return 2;
  if (status === 'in_progress') return 3;
  if (status === 'completed') return 4;
  return 1;
};
</script>

<template>
  <Head :title="`سفارش ${order.order_number} | سلمیر`" />

  <AppLayout>
    <div class="max-w-5xl mx-auto space-y-6">
      
      <!-- Top Action Bar -->
      <div class="flex items-center justify-between">
        <Link 
          :href="route('orders.index')" 
          class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-blue-600 bg-white border border-slate-200 transition"
        >
          <ArrowLeft class="w-4 h-4 rotate-180" />
          <span>بازگشت به سفارشات</span>
        </Link>

        <span class="text-xs font-mono font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-lg border border-blue-200/60">
          {{ order.order_number }}
        </span>
      </div>

      <!-- Stepper / Status Progress Bar -->
      <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
        <div class="flex items-center justify-between mb-4">
          <div class="text-xs font-bold text-slate-500">مسیر پیشرفت سفارش</div>
          <span 
            class="px-3 py-1 rounded-full text-xs font-bold border"
            :class="getStatusBadge(order.status).class"
          >
            {{ getStatusBadge(order.status).label }}
          </span>
        </div>

        <div class="grid grid-cols-4 gap-2 pt-2">
          <div 
            class="h-2 rounded-full transition-all"
            :class="getStepNumber(order.status) >= 1 ? 'bg-blue-600' : 'bg-slate-200'"
          ></div>
          <div 
            class="h-2 rounded-full transition-all"
            :class="getStepNumber(order.status) >= 2 ? 'bg-blue-600' : 'bg-slate-200'"
          ></div>
          <div 
            class="h-2 rounded-full transition-all"
            :class="getStepNumber(order.status) >= 3 ? 'bg-blue-600' : 'bg-slate-200'"
          ></div>
          <div 
            class="h-2 rounded-full transition-all"
            :class="getStepNumber(order.status) >= 4 ? 'bg-emerald-500' : 'bg-slate-200'"
          ></div>
        </div>

        <div class="grid grid-cols-4 gap-2 mt-2 text-[11px] font-bold text-slate-500 text-center">
          <span>۱. ثبت اولیه</span>
          <span>۲. تایید فنی</span>
          <span>۳. توسعه و تست</span>
          <span>۴. استقرار و تحویل</span>
        </div>
      </div>

      <!-- Main Order Details Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Main Information (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
            <div>
              <div class="text-xs text-blue-600 font-bold mb-1">{{ order.service_type }}</div>
              <h1 class="text-2xl font-black text-slate-900">{{ order.title }}</h1>
            </div>

            <div class="border-t border-slate-100 pt-4">
              <h4 class="text-xs font-bold text-slate-400 mb-2">شرح نیازمندی‌ها و توضیحات:</h4>
              <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap bg-slate-50 p-5 rounded-2xl border border-slate-100">
                {{ order.description }}
              </p>
            </div>

            <!-- Admin Notes (if available) -->
            <div v-if="order.admin_notes" class="border-t border-slate-100 pt-4">
              <h4 class="text-xs font-bold text-amber-700 mb-2 flex items-center gap-1.5">
                <ShieldCheck class="w-4 h-4" />
                <span>یادداشت کارشناس فنی سلمیر:</span>
              </h4>
              <p class="text-xs text-slate-700 leading-relaxed bg-amber-50/70 p-4 rounded-2xl border border-amber-200">
                {{ order.admin_notes }}
              </p>
            </div>

            <!-- Attachments -->
            <div v-if="order.attachments && order.attachments.length > 0" class="border-t border-slate-100 pt-4">
              <h4 class="text-xs font-bold text-slate-400 mb-3 flex items-center gap-1.5">
                <Paperclip class="w-4 h-4" />
                <span>فایل‌های پیوست سفارش:</span>
              </h4>
              <div class="space-y-2">
                <div 
                  v-for="att in order.attachments" 
                  :key="att.id"
                  class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs"
                >
                  <span class="font-mono font-bold text-slate-800">{{ att.file_name }}</span>
                  <a 
                    :href="route('orders.attachments.download', [order.id, att.id])" 
                    class="text-blue-600 hover:text-blue-800 font-bold flex items-center gap-1"
                  >
                    <Download class="w-3.5 h-3.5" />
                    <span>دانلود امن</span>
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Right: Specs Sidebar (1 col) -->
        <div class="space-y-6">
          <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">مشخصات کلیدی</h3>

            <div class="space-y-3.5 text-xs">
              <div class="flex items-center justify-between">
                <span class="text-slate-400 flex items-center gap-1.5">
                  <Coins class="w-4 h-4 text-blue-600" />
                  محدوده بودجه:
                </span>
                <span class="font-bold text-slate-800">{{ order.budget_range || 'توافقی' }}</span>
              </div>

              <div class="flex items-center justify-between">
                <span class="text-slate-400 flex items-center gap-1.5">
                  <Calendar class="w-4 h-4 text-blue-600" />
                  مهلت مورد نظر:
                </span>
                <span class="font-bold text-slate-800">{{ order.deadline || 'تعیین نشده' }}</span>
              </div>

              <div class="flex items-center justify-between">
                <span class="text-slate-400 flex items-center gap-1.5">
                  <Clock class="w-4 h-4 text-blue-600" />
                  تاریخ ثبت:
                </span>
                <span class="font-bold text-slate-800 font-mono">{{ new Date(order.created_at).toLocaleDateString('fa-IR') }}</span>
              </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
              <Link 
                :href="route('tickets.create')" 
                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition"
              >
                <span>گفتگو با تیم فنی درباره این سفارش</span>
              </Link>
            </div>
          </div>
        </div>

      </div>

    </div>
  </AppLayout>
</template>
