<template>
  <AdminLayout>
    <Head title="مدیریت سفارشات" />
    
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-slate-800">سفارشات</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium">شماره سفارش</th>
              <th class="p-4 font-medium">مشتری</th>
              <th class="p-4 font-medium">عنوان پروژه</th>
              <th class="p-4 font-medium">وضعیت</th>
              <th class="p-4 font-medium">تاریخ ثبت</th>
              <th class="p-4 font-medium">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders.data" :key="order.id" class="border-b border-slate-100 hover:bg-slate-50">
              <td class="p-4 font-mono text-sm">{{ order.order_number }}</td>
              <td class="p-4">{{ order.user?.name || 'کاربر' }}</td>
              <td class="p-4 font-medium">{{ order.title }}</td>
              <td class="p-4">
                <span class="px-2 py-1 text-xs rounded-full" :class="{
                  'bg-yellow-100 text-yellow-700': order.status === 'pending',
                  'bg-blue-100 text-blue-700': order.status === 'confirmed',
                  'bg-purple-100 text-purple-700': order.status === 'in_progress',
                  'bg-green-100 text-green-700': order.status === 'completed',
                  'bg-red-100 text-red-700': order.status === 'cancelled',
                }">
                  {{ getStatusText(order.status) }}
                </span>
              </td>
              <td class="p-4 text-slate-600">{{ new Date(order.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4">
                <Link :href="`/admin/orders/${order.id}`" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                  مشاهده
                </Link>
              </td>
            </tr>
            <tr v-if="orders.data.length === 0">
              <td colspan="6" class="p-4 text-center text-slate-500">سفارشی یافت نشد.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="p-4 border-t border-slate-200 flex justify-center gap-1" v-if="orders.links && orders.links.length > 3">
        <template v-for="(link, i) in orders.links" :key="i">
          <Link
            v-if="link.url"
            :href="link.url"
            class="px-3 py-1 border rounded text-sm"
            :class="link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-300 hover:bg-slate-50'"
            v-html="link.label"
          />
          <span v-else class="px-3 py-1 border rounded text-sm bg-slate-50 text-slate-400 border-slate-200" v-html="link.label"></span>
        </template>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  orders: Object,
});

const getStatusText = (status) => {
  const statuses = {
    pending: 'در انتظار بررسی',
    confirmed: 'تایید شده',
    in_progress: 'در حال انجام',
    completed: 'تکمیل شده',
    cancelled: 'لغو شده'
  };
  return statuses[status] || status;
};
</script>
