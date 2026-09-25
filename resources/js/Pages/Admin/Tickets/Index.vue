<template>
  <AdminLayout>
    <Head title="مدیریت تیکت‌ها" />

    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">تیکت‌های پشتیبانی</h1>
        <p class="text-xs text-slate-500 mt-1">مدیریت و پاسخگویی به درخواست‌های پشتیبانی کاربران</p>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium text-xs">شماره تیکت</th>
              <th class="p-4 font-medium text-xs">کاربر</th>
              <th class="p-4 font-medium text-xs">موضوع</th>
              <th class="p-4 font-medium text-xs">وضعیت</th>
              <th class="p-4 font-medium text-xs">اولویت</th>
              <th class="p-4 font-medium text-xs">تاریخ</th>
              <th class="p-4 font-medium text-xs text-center">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ticket in tickets.data" :key="ticket.id" class="border-b border-slate-100 hover:bg-slate-50/70 transition">
              <td class="p-4 font-mono text-xs font-bold text-slate-500">{{ ticket.ticket_number }}</td>
              <td class="p-4">
                <div class="text-sm font-medium text-slate-900">{{ ticket.user?.name || 'کاربر' }}</div>
                <div class="text-xs text-slate-400 font-mono" v-if="ticket.user?.email">{{ ticket.user.email }}</div>
              </td>
              <td class="p-4 font-medium text-slate-800 text-sm">{{ ticket.title }}</td>
              <td class="p-4">
                <StatusBadge :status="ticket.status" kind="ticket" />
              </td>
              <td class="p-4">
                <StatusBadge :status="ticket.priority" kind="priority" />
              </td>
              <td class="p-4 text-xs text-slate-500 font-mono">{{ new Date(ticket.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4 text-center">
                <Link :href="route('admin.tickets.show', ticket.id)" class="text-blue-600 hover:text-blue-800 text-xs font-bold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition inline-block">
                  مشاهده و پاسخ
                </Link>
              </td>
            </tr>
            <tr v-if="tickets.data.length === 0">
              <td colspan="7" class="p-12 text-center text-slate-400 text-sm">
                هیچ تیکتی ثبت نشده است.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Persian Pagination -->
      <Pagination
        :links="tickets.links || []"
        :from="tickets.from"
        :to="tickets.to"
        :total="tickets.total"
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
  tickets: Object,
});
</script>
