<template>
  <AdminLayout>
    <Head title="مدیریت نمونه‌کارها" />
    
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-slate-800">نمونه‌کارها</h1>
      <Link href="/admin/portfolios/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        افزودن نمونه‌کار جدید
      </Link>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium">تصویر</th>
              <th class="p-4 font-medium">عنوان</th>
              <th class="p-4 font-medium">دسته‌بندی</th>
              <th class="p-4 font-medium">ویژه</th>
              <th class="p-4 font-medium">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="portfolio in portfolios" :key="portfolio.id" class="border-b border-slate-100 hover:bg-slate-50">
              <td class="p-4">
                <img v-if="portfolio.image" :src="portfolio.image.startsWith('http') ? portfolio.image : `/storage/${portfolio.image}`" class="w-16 h-12 object-cover rounded" alt="portfolio" />
              </td>
              <td class="p-4 font-medium">{{ portfolio.title }}</td>
              <td class="p-4 text-slate-600">{{ portfolio.category }}</td>
              <td class="p-4">
                <span v-if="portfolio.is_featured" class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded text-xs">ویژه</span>
              </td>
              <td class="p-4 flex items-center gap-3">
                <Link :href="`/admin/portfolios/${portfolio.id}/edit`" class="text-blue-600 hover:text-blue-800 text-sm">
                  ویرایش
                </Link>
                <button @click="deletePortfolio(portfolio)" class="text-red-500 hover:text-red-700 text-sm">
                  حذف
                </button>
              </td>
            </tr>
            <tr v-if="portfolios.length === 0">
              <td colspan="5" class="p-4 text-center text-slate-500">موردی یافت نشد.</td>
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
  portfolios: Array,
});

const deletePortfolio = (portfolio) => {
  if (confirm('آیا از حذف این نمونه‌کار اطمینان دارید؟')) {
    router.delete(`/admin/portfolios/${portfolio.id}`);
  }
};
</script>
