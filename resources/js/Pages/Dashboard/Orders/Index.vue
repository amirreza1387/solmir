<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
  ShoppingBag, 
  PlusCircle, 
  ArrowLeft, 
  Clock, 
  CheckCircle2, 
  AlertCircle, 
  FileText 
} from 'lucide-vue-next';

defineProps({
  orders: {
    type: Array,
    required: true
  }
});

const getStatusBadge = (status) => {
  const map = {
    pending: { label: 'در انتظار بررسی', class: 'bg-amber-100 text-amber-800 border-amber-200' },
    confirmed: { label: 'تایید شده', class: 'bg-blue-100 text-blue-800 border-blue-200' },
    in_progress: { label: 'در حال انجام', class: 'bg-indigo-100 text-indigo-800 border-indigo-200' },
    completed: { label: 'تکمیل شده', class: 'bg-emerald-100 text-emerald-800 border-emerald-200' },
    cancelled: { label: 'لغو شده', class: 'bg-rose-100 text-rose-800 border-rose-200' }
  };
  return map[status] || { label: status, class: 'bg-slate-100 text-slate-800 border-slate-200' };
};
</script>

<template>
  <Head title="سفارشات من | سلمیر" />

  <AppLayout>
    <div class="space-y-6 max-w-7xl mx-auto">
      
      <!-- Top Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100/70 text-blue-700 text-xs font-bold mb-2">
            <ShoppingBag class="w-3.5 h-3.5" />
            <span>مدیریت پروژه‌ها</span>
          </div>
          <h1 class="text-2xl font-black text-slate-900">سفارشات اختصاصی من</h1>
          <p class="text-xs text-slate-500 mt-1">مشاهده، پیگیری وضعیت، و فایل‌های مربوط به سفارشات ثبت‌شده شما.</p>
        </div>

        <Link 
          :href="route('orders.create')" 
          class="px-5 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-blue-500/20 hover:shadow-lg transition flex items-center gap-2 self-start sm:self-auto"
        >
          <PlusCircle class="w-4 h-4" />
          <span>ثبت سفارش جدید</span>
        </Link>
      </div>

      <!-- Orders Content Card -->
      <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
        
        <div v-if="orders.length === 0" class="text-center py-20 px-4">
          <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center mx-auto mb-4">
            <ShoppingBag class="w-8 h-8 opacity-60" />
          </div>
          <h3 class="text-lg font-bold text-slate-800">هیچ سفارشی ثبت نشده است</h3>
          <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
            برای شروع همکاری با تیم سلمیر، اولین سفارش طراحی یا توسعه خود را به‌سادگی ثبت کنید.
          </p>
          <Link 
            :href="route('orders.create')" 
            class="inline-flex items-center gap-2 mt-6 px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition shadow-sm"
          >
            <PlusCircle class="w-4 h-4" />
            <span>ثبت اولین سفارش</span>
          </Link>
        </div>

        <div v-else class="overflow-x-auto">
          <table class="w-full text-right text-sm">
            <thead class="bg-slate-50 text-xs font-bold text-slate-500 uppercase border-b border-slate-100">
              <tr>
                <th class="px-6 py-4">کد سفارش</th>
                <th class="px-6 py-4">عنوان پروژه</th>
                <th class="px-6 py-4">نوع خدمت</th>
                <th class="px-6 py-4">وضعیت</th>
                <th class="px-6 py-4">تاریخ ثبت</th>
                <th class="px-6 py-4 text-center">عملیات</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr 
                v-for="order in orders" 
                :key="order.id"
                class="hover:bg-blue-50/40 transition"
              >
                <td class="px-6 py-4 font-mono font-bold text-blue-700 text-xs">
                  {{ order.order_number }}
                </td>
                <td class="px-6 py-4 font-bold text-slate-900">
                  {{ order.title }}
                </td>
                <td class="px-6 py-4 text-xs text-slate-600">
                  {{ order.service_type }}
                </td>
                <td class="px-6 py-4">
                  <span 
                    class="px-2.5 py-1 rounded-full text-xs font-bold border inline-block"
                    :class="getStatusBadge(order.status).class"
                  >
                    {{ getStatusBadge(order.status).label }}
                  </span>
                </td>
                <td class="px-6 py-4 text-xs text-slate-400 font-mono">
                  {{ new Date(order.created_at).toLocaleDateString('fa-IR') }}
                </td>
                <td class="px-6 py-4 text-center">
                  <Link 
                    :href="route('orders.show', order.id)" 
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 transition"
                  >
                    <span>جزئیات</span>
                    <ArrowLeft class="w-3.5 h-3.5" />
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>

    </div>
  </AppLayout>
</template>
