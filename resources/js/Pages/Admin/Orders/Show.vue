<template>
  <AdminLayout>
    <Head :title="'سفارش ' + order.order_number" />
    
    <div class="mb-6">
      <Link href="/admin/orders" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">جزئیات سفارش {{ order.order_number }}</h1>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Order Info -->
      <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
          <h2 class="text-lg font-bold text-slate-800 mb-4">اطلاعات سفارش</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6">
            <div>
              <span class="text-slate-500 block mb-1">مشتری</span>
              <div class="font-medium text-slate-800">{{ order.user?.name || 'کاربر' }} ({{ order.user?.email || '-' }})</div>
            </div>
            <div>
              <span class="text-slate-500 block mb-1">تاریخ ثبت</span>
              <div class="font-medium text-slate-800">{{ new Date(order.created_at).toLocaleDateString('fa-IR') }}</div>
            </div>
          </div>

          <div class="mb-6">
            <span class="text-slate-500 block mb-1 text-sm">عنوان پروژه</span>
            <div class="font-bold text-lg text-slate-800">{{ order.title }}</div>
          </div>

          <div>
            <span class="text-slate-500 block mb-2 text-sm">توضیحات پروژه</span>
            <div class="bg-slate-50 p-4 rounded-lg text-slate-700 whitespace-pre-wrap leading-relaxed">{{ order.description }}</div>
          </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
          <h2 class="text-lg font-bold text-slate-800 mb-4">فایل‌های پیوست ({{ order.attachments.length }})</h2>
          
          <ul v-if="order.attachments.length > 0" class="space-y-3">
            <li v-for="file in order.attachments" :key="file.id" class="flex items-center justify-between p-3 border border-slate-200 rounded-lg bg-slate-50">
              <span class="text-sm font-medium text-slate-700 truncate mr-2">{{ file.file_name }}</span>
              <a :href="route('orders.attachments.download', [order.id, file.id])" class="text-blue-600 hover:text-blue-800 text-sm whitespace-nowrap font-bold">
                دانلود امن
              </a>
            </li>
          </ul>
          <div v-else class="text-slate-500 text-sm">هیچ فایلی پیوست نشده است.</div>
        </div>
      </div>

      <!-- Admin Actions -->
      <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
          <h2 class="text-lg font-bold text-slate-800 mb-4">مدیریت سفارش</h2>
          
          <form @submit.prevent="updateStatus">
            <div class="mb-4">
              <label class="block text-sm font-medium text-slate-700 mb-1">وضعیت سفارش</label>
              <select v-model="form.status" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="pending">در انتظار بررسی</option>
                <option value="confirmed">تایید شده</option>
                <option value="in_progress">در حال انجام</option>
                <option value="completed">تکمیل شده</option>
                <option value="cancelled">لغو شده</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-slate-700 mb-1">یادداشت مدیر (محرمانه)</label>
              <textarea v-model="form.admin_notes" rows="4" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="فقط برای مدیران قابل مشاهده است"></textarea>
            </div>

            <button type="submit" :disabled="form.processing" class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
              بروزرسانی وضعیت
            </button>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  order: Object,
});

const form = useForm({
  status: props.order.status,
  admin_notes: props.order.admin_notes || '',
});

const updateStatus = () => {
  form.put(`/admin/orders/${props.order.id}/status`, {
    preserveScroll: true,
  });
};
</script>
