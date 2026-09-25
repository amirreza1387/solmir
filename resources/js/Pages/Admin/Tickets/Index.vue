<template>
  <AdminLayout>
    <Head title="مدیریت تیکت‌ها" />
    
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-slate-800">تیکت‌های پشتیبانی</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium">شماره تیکت</th>
              <th class="p-4 font-medium">کاربر</th>
              <th class="p-4 font-medium">موضوع</th>
              <th class="p-4 font-medium">وضعیت</th>
              <th class="p-4 font-medium">اولویت</th>
              <th class="p-4 font-medium">تاریخ</th>
              <th class="p-4 font-medium">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ticket in tickets.data" :key="ticket.id" class="border-b border-slate-100 hover:bg-slate-50">
              <td class="p-4 font-mono text-sm text-slate-500">{{ ticket.ticket_number }}</td>
              <td class="p-4">{{ ticket.user?.name || 'کاربر' }}</td>
              <td class="p-4 font-medium">{{ ticket.title }}</td>
              <td class="p-4">
                <StatusBadge :status="ticket.status" kind="ticket" />
              </td>
              <td class="p-4">
                <StatusBadge :status="ticket.priority" kind="priority" />
              </td>
              <td class="p-4 text-slate-600">{{ new Date(ticket.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4">
                <Link :href="`/admin/tickets/${ticket.id}`" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                  مشاهده
                </Link>
              </td>
            </tr>
            <tr v-if="tickets.data.length === 0">
              <td colspan="7" class="p-4 text-center text-slate-500">تیکتی یافت نشد.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="p-4 border-t border-slate-200 flex justify-center gap-1" v-if="tickets.links && tickets.links.length > 3">
        <template v-for="(link, i) in tickets.links" :key="i">
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
import StatusBadge from '@/Components/StatusBadge.vue';

defineProps({
  tickets: Object,
});


</script>
