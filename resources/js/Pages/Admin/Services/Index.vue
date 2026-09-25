<template>
  <AdminLayout>
    <Head title="مدیریت خدمات" />

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">خدمات سامانه</h1>
        <p class="text-xs text-slate-500 mt-1">مدیریت لیست خدمات و حوزه‌های تخصصی آژانس نرم‌افزاری سلمیر</p>
      </div>
      <Link href="/admin/services/create" class="px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition text-xs font-bold shadow-xs self-start sm:self-auto">
        + افزودن خدمت جدید
      </Link>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium text-xs">ترتیب</th>
              <th class="p-4 font-medium text-xs">عنوان خدمت</th>
              <th class="p-4 font-medium text-xs">وضعیت</th>
              <th class="p-4 font-medium text-xs text-center">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="service in serviceList" :key="service.id" class="border-b border-slate-100 hover:bg-slate-50/70 transition">
              <td class="p-4 font-mono text-xs text-slate-500">{{ service.sort_order }}</td>
              <td class="p-4 font-bold text-sm text-slate-800">{{ service.title }}</td>
              <td class="p-4">
                <span v-if="service.is_active" class="text-emerald-700 bg-emerald-100 font-bold px-2 py-0.5 rounded-full text-xs">فعال</span>
                <span v-else class="text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full text-xs">غیرفعال</span>
              </td>
              <td class="p-4 text-center">
                <div class="inline-flex items-center gap-2">
                  <Link :href="`/admin/services/${service.id}/edit`" class="text-blue-600 hover:text-blue-800 text-xs font-bold bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg transition">
                    ویرایش
                  </Link>
                  <button
                    type="button"
                    @click="promptDelete(service)"
                    class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1 rounded hover:bg-red-50 transition cursor-pointer"
                  >
                    حذف
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="serviceList.length === 0">
              <td colspan="4" class="p-12 text-center text-slate-400 text-sm">
                هیچ خدمتی ثبت نشده است.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Persian Pagination -->
      <Pagination
        :links="services?.links || []"
        :from="services?.from"
        :to="services?.to"
        :total="services?.total ?? serviceList.length"
      />
    </div>

    <!-- Confirm Modal -->
    <ConfirmModal
      :show="showDeleteModal"
      title="حذف خدمت"
      :message="`آیا از حذف خدمت '${selectedItem?.title}' اطمینان دارید؟`"
      confirm-text="بله، حذف شود"
      cancel-text="انصراف"
      :loading="isDeleting"
      @confirm="confirmDelete"
      @close="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';

const props = defineProps({
  services: [Array, Object],
});

const serviceList = computed(() => {
  if (Array.isArray(props.services)) return props.services;
  return props.services?.data || [];
});

const showDeleteModal = ref(false);
const selectedItem = ref(null);
const isDeleting = ref(false);

const promptDelete = (service) => {
  selectedItem.value = service;
  showDeleteModal.value = true;
};

const confirmDelete = () => {
  if (!selectedItem.value || isDeleting.value) return;
  isDeleting.value = true;
  router.delete(`/admin/services/${selectedItem.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false;
      selectedItem.value = null;
    },
    onFinish: () => {
      isDeleting.value = false;
    },
  });
};
</script>
