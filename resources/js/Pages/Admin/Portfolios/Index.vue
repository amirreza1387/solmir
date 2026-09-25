<template>
  <AdminLayout>
    <Head title="مدیریت نمونه‌کارها" />

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">نمونه‌کارهای سلمیر</h1>
        <p class="text-xs text-slate-500 mt-1">مدیریت و نمایش پروژه‌های انجام‌شده در پورتفولیوی عمومی</p>
      </div>
      <Link href="/admin/portfolios/create" class="px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition text-xs font-bold shadow-xs self-start sm:self-auto">
        + افزودن نمونه‌کار جدید
      </Link>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium text-xs">تصویر</th>
              <th class="p-4 font-medium text-xs">عنوان پروژه</th>
              <th class="p-4 font-medium text-xs">دسته‌بندی</th>
              <th class="p-4 font-medium text-xs">وضعیت</th>
              <th class="p-4 font-medium text-xs text-center">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="portfolio in portfolioList" :key="portfolio.id" class="border-b border-slate-100 hover:bg-slate-50/70 transition">
              <td class="p-4">
                <img v-if="portfolio.image" :src="portfolio.image.startsWith('http') ? portfolio.image : `/storage/${portfolio.image}`" class="w-14 h-10 object-cover rounded-lg border border-slate-200" alt="portfolio" />
                <div v-else class="w-14 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] text-slate-400">بدون تصویر</div>
              </td>
              <td class="p-4 font-bold text-sm text-slate-800">{{ portfolio.title }}</td>
              <td class="p-4 text-xs text-slate-600">{{ portfolio.category }}</td>
              <td class="p-4">
                <span v-if="portfolio.is_featured" class="text-amber-700 bg-amber-100 font-bold px-2 py-0.5 rounded-full text-xs">ویژه</span>
                <span v-else class="text-slate-400 text-xs">عادی</span>
              </td>
              <td class="p-4 text-center">
                <div class="inline-flex items-center gap-2">
                  <Link :href="`/admin/portfolios/${portfolio.id}/edit`" class="text-blue-600 hover:text-blue-800 text-xs font-bold bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg transition">
                    ویرایش
                  </Link>
                  <button
                    type="button"
                    @click="promptDelete(portfolio)"
                    class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1 rounded hover:bg-red-50 transition cursor-pointer"
                  >
                    حذف
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="portfolioList.length === 0">
              <td colspan="5" class="p-12 text-center text-slate-400 text-sm">
                هیچ نمونه‌کاری ثبت نشده است.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Persian Pagination -->
      <Pagination
        :links="portfolios?.links || []"
        :from="portfolios?.from"
        :to="portfolios?.to"
        :total="portfolios?.total ?? portfolioList.length"
      />
    </div>

    <!-- Confirm Modal -->
    <ConfirmModal
      :show="showDeleteModal"
      title="حذف نمونه‌کار"
      :message="`آیا از حذف نمونه‌کار '${selectedItem?.title}' اطمینان دارید؟`"
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
  portfolios: [Array, Object],
});

const portfolioList = computed(() => {
  if (Array.isArray(props.portfolios)) return props.portfolios;
  return props.portfolios?.data || [];
});

const showDeleteModal = ref(false);
const selectedItem = ref(null);
const isDeleting = ref(false);

const promptDelete = (portfolio) => {
  selectedItem.value = portfolio;
  showDeleteModal.value = true;
};

const confirmDelete = () => {
  if (!selectedItem.value || isDeleting.value) return;
  isDeleting.value = true;
  router.delete(`/admin/portfolios/${selectedItem.value.id}`, {
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
