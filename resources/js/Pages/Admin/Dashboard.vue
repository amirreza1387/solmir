<template>
  <AdminLayout>
    <Head title="داشبورد مدیریت | سلمیر" />
    
    <div class="mb-8">
      <h1 class="text-2xl font-black text-slate-900">خلاصه وضعیت سیستم</h1>
      <p class="text-xs text-slate-500 mt-1">نمای کلی آمار سفارشات، کاربران و درخواست‌های پشتیبانی</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
      <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
          <div class="text-slate-500 text-xs font-bold mb-1.5">کل کاربران</div>
          <div class="text-3xl font-black text-slate-800">{{ usersCount }}</div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
          <Users class="w-6 h-6" />
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
          <div class="text-slate-500 text-xs font-bold mb-1.5">کل سفارشات</div>
          <div class="text-3xl font-black text-slate-800">{{ ordersCount }}</div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
          <ShoppingBag class="w-6 h-6" />
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
          <div class="text-slate-500 text-xs font-bold mb-1.5">تیکت‌های باز</div>
          <div class="text-3xl font-black text-amber-600">{{ openTicketsCount }}</div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
          <MessageSquare class="w-6 h-6" />
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
          <div class="text-slate-500 text-xs font-bold mb-1.5">پیام‌های جدید تماس</div>
          <div class="text-3xl font-black text-rose-600">{{ unreadContactsCount }}</div>
        </div>
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
          <Mail class="w-6 h-6" />
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Recent Orders -->
      <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
          <h2 class="font-bold text-slate-800 text-sm">آخرین سفارشات ثبت‌شده</h2>
          <Link href="/admin/orders" class="text-xs font-bold text-blue-600 hover:text-blue-800">مشاهده همه &larr;</Link>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-right text-xs">
            <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
              <tr>
                <th class="p-3.5 font-bold">شماره</th>
                <th class="p-3.5 font-bold">مشتری</th>
                <th class="p-3.5 font-bold">وضعیت</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="order in latestOrders" :key="order.id" class="hover:bg-slate-50/80 transition">
                <td class="p-3.5 font-mono font-medium text-slate-700">
                  <Link :href="`/admin/orders/${order.id}`" class="text-blue-600 hover:underline">
                    {{ order.order_number }}
                  </Link>
                </td>
                <td class="p-3.5 font-medium text-slate-800">{{ order.user?.name || 'کاربر' }}</td>
                <td class="p-3.5">
                  <span class="px-2 py-0.5 rounded-full font-bold" :class="getOrderStatusBadge(order.status).class">
                    {{ getOrderStatusBadge(order.status).label }}
                  </span>
                </td>
              </tr>
              <tr v-if="latestOrders.length === 0">
                <td colspan="3" class="p-6 text-center text-slate-400">سفارشی یافت نشد</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Recent Tickets -->
      <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
          <h2 class="font-bold text-slate-800 text-sm">آخرین تیکت‌های پشتیبانی</h2>
          <Link href="/admin/tickets" class="text-xs font-bold text-blue-600 hover:text-blue-800">مشاهده همه &larr;</Link>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-right text-xs">
            <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
              <tr>
                <th class="p-3.5 font-bold">موضوع</th>
                <th class="p-3.5 font-bold">کاربر</th>
                <th class="p-3.5 font-bold">وضعیت</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="ticket in latestTickets" :key="ticket.id" class="hover:bg-slate-50/80 transition">
                <td class="p-3.5 font-medium text-slate-800">
                  <Link :href="`/admin/tickets/${ticket.id}`" class="hover:text-blue-600">
                    {{ ticket.title }}
                  </Link>
                </td>
                <td class="p-3.5 text-slate-600">{{ ticket.user?.name || 'کاربر' }}</td>
                <td class="p-3.5">
                  <span class="px-2 py-0.5 rounded-full font-bold" :class="getTicketStatusBadge(ticket.status).class">
                    {{ getTicketStatusBadge(ticket.status).label }}
                  </span>
                </td>
              </tr>
              <tr v-if="latestTickets.length === 0">
                <td colspan="3" class="p-6 text-center text-slate-400">تیکتی یافت نشد</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Users, ShoppingBag, MessageSquare, Mail } from 'lucide-vue-next';

defineProps({
  usersCount: Number,
  ordersCount: Number,
  openTicketsCount: Number,
  unreadContactsCount: Number,
  latestOrders: Array,
  latestTickets: Array,
});

const getOrderStatusBadge = (status) => {
  const map = {
    pending: { label: 'در انتظار بررسی', class: 'bg-amber-100 text-amber-800' },
    confirmed: { label: 'تایید شده', class: 'bg-blue-100 text-blue-800' },
    in_progress: { label: 'در حال انجام', class: 'bg-indigo-100 text-indigo-800' },
    completed: { label: 'تکمیل شده', class: 'bg-emerald-100 text-emerald-800' },
    cancelled: { label: 'لغو شده', class: 'bg-rose-100 text-rose-800' }
  };
  return map[status] || { label: status, class: 'bg-slate-100 text-slate-700' };
};

const getTicketStatusBadge = (status) => {
  const map = {
    open: { label: 'باز', class: 'bg-amber-100 text-amber-800' },
    in_progress: { label: 'در حال بررسی', class: 'bg-blue-100 text-blue-800' },
    answered: { label: 'پاسخ داده شده', class: 'bg-purple-100 text-purple-800' },
    closed: { label: 'بسته شده', class: 'bg-slate-100 text-slate-600' }
  };
  return map[status] || { label: status, class: 'bg-slate-100 text-slate-700' };
};
</script>
