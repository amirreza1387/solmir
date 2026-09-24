<template>
  <AdminLayout>
    <Head title="مدیریت خدمات" />
    
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-slate-800">خدمات</h1>
      <Link href="/admin/services/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        افزودن خدمت جدید
      </Link>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium">ترتیب</th>
              <th class="p-4 font-medium">عنوان</th>
              <th class="p-4 font-medium">وضعیت</th>
              <th class="p-4 font-medium">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="service in services" :key="service.id" class="border-b border-slate-100 hover:bg-slate-50">
              <td class="p-4">{{ service.sort_order }}</td>
              <td class="p-4 font-medium">{{ service.title }}</td>
              <td class="p-4">
                <span v-if="service.is_active" class="text-green-600 bg-green-100 px-2 py-1 rounded text-xs">فعال</span>
                <span v-else class="text-slate-500 bg-slate-100 px-2 py-1 rounded text-xs">غیرفعال</span>
              </td>
              <td class="p-4 flex items-center gap-3">
                <Link :href="`/admin/services/${service.id}/edit`" class="text-blue-600 hover:text-blue-800 text-sm">
                  ویرایش
                </Link>
                <button @click="deleteService(service)" class="text-red-500 hover:text-red-700 text-sm">
                  حذف
                </button>
              </td>
            </tr>
            <tr v-if="services.length === 0">
              <td colspan="4" class="p-4 text-center text-slate-500">موردی یافت نشد.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  services: Array,
});

const deleteService = (service) => {
  if (confirm('آیا از حذف این خدمت اطمینان دارید؟')) {
    router.delete(`/admin/services/${service.id}`);
  }
};
</script>
