<template>
  <AdminLayout>
    <Head title="مشاهده پیام" />

    <div class="mb-6">
      <Link href="/admin/contacts" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">مشاهده پیام</h1>
        <button
          type="button"
          @click="showDeleteModal = true"
          class="px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition text-xs font-bold cursor-pointer"
        >
          حذف پیام
        </button>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm max-w-3xl">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 mb-6 pb-6 border-b border-slate-100">
        <div>
          <span class="text-slate-500 text-xs block mb-1">فرستنده</span>
          <div class="font-medium text-slate-800 text-sm">{{ contact.name }}</div>
        </div>
        <div>
          <span class="text-slate-500 text-xs block mb-1">تاریخ ارسال</span>
          <div class="font-medium text-slate-800 text-xs font-mono" dir="ltr">{{ new Date(contact.created_at).toLocaleString('fa-IR') }}</div>
        </div>
        <div>
          <span class="text-slate-500 text-xs block mb-1">ایمیل</span>
          <div class="font-medium text-slate-800 text-sm font-mono">
            <a :href="`mailto:${contact.email}`" class="text-blue-600 hover:underline">{{ contact.email }}</a>
          </div>
        </div>
        <div>
          <span class="text-slate-500 text-xs block mb-1">شماره تماس</span>
          <div class="font-medium text-slate-800 text-sm font-mono" dir="ltr">{{ contact.phone || '---' }}</div>
        </div>
      </div>

      <div class="mb-4">
        <span class="text-slate-500 text-xs block mb-1">موضوع</span>
        <div class="font-bold text-base text-slate-800">{{ contact.subject || 'بدون موضوع' }}</div>
      </div>

      <div>
        <span class="text-slate-500 text-xs block mb-2">متن پیام</span>
        <div class="bg-slate-50 p-5 rounded-xl text-slate-700 whitespace-pre-wrap leading-loose text-sm border border-slate-100">
          {{ contact.message }}
        </div>
      </div>

      <div class="mt-8 flex gap-3">
        <a :href="`mailto:${contact.email}`" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition text-xs font-bold shadow-xs">
          پاسخ از طریق ایمیل
        </a>
      </div>
    </div>

    <!-- Confirm Modal -->
    <ConfirmModal
      :show="showDeleteModal"
      title="حذف پیام تماس"
      :message="`آیا از حذف پیام ارسالی توسط '${contact.name}' اطمینان دارید؟`"
      confirm-text="بله، حذف شود"
      cancel-text="انصراف"
      :loading="isDeleting"
      @confirm="confirmDelete"
      @close="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';

const props = defineProps({
  contact: Object,
});

const showDeleteModal = ref(false);
const isDeleting = ref(false);

const confirmDelete = () => {
  if (isDeleting.value) return;
  isDeleting.value = true;
  router.delete(`/admin/contacts/${props.contact.id}`, {
    onFinish: () => {
      isDeleting.value = false;
    },
  });
};
</script>
