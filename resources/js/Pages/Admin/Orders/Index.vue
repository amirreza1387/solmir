<template>
  <AdminLayout>
    <Head title="مدیریت سفارشات" />

    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">سفارشات مشتریان</h1>
        <p class="text-xs text-slate-500 mt-1">مشاهده و بررسی پروژه‌های ثبت‌شده توسط کاربران</p>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium text-xs">شماره سفارش</th>
              <th class="p-4 font-medium text-xs">مشتری</th>
              <th class="p-4 font-medium text-xs">عنوان پروژه</th>
              <th class="p-4 font-medium text-xs">وضعیت</th>
              <th class="p-4 font-medium text-xs">تاریخ ثبت</th>
              <th class="p-4 font-medium text-xs text-center">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders.data" :key="order.id" class="border-b border-slate-100 hover:bg-slate-50/70 transition">
              <td class="p-4 font-mono text-xs font-bold text-blue-700">{{ order.order_number }}</td>
              <td class="p-4">
                <div class="text-sm font-medium text-slate-900">{{ order.user?.name || 'کاربر' }}</div>
                <div class="text-xs text-slate-400 font-mono" v-if="order.user?.email">{{ order.user.email }}</div>
              </td>
              <td class="p-4 font-medium text-slate-800 text-sm">{{ order.title }}</td>
              <td class="p-4">
                <StatusBadge :status="order.status" />
              </td>
              <td class="p-4 text-xs text-slate-500 font-mono">{{ new Date(order.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4 text-center">
                <Link :href="route('admin.orders.show', order.id)" class="text-blue-600 hover:text-blue-800 text-xs font-bold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition inline-block">
                  مشاهده و بررسی
                </Link>
              </td>
            </tr>
            <tr v-if="orders.data.length === 0">
              <td colspan="6" class="p-12 text-center text-slate-400 text-sm">
                هیچ سفارشی ثبت نشده است.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Persian Pagination -->
      <Pagination
        :links="orders.links || []"
        :from="orders.from"
        :to="orders.to"
        :total="orders.total"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
  orders: Object,
});
</script>
