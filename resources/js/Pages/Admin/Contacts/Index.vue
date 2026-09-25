<template>
  <AdminLayout>
    <Head title="پیام‌های تماس" />

    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">پیام‌های تماس با ما</h1>
        <p class="text-xs text-slate-500 mt-1">مشاهده و بررسی پیام‌های ارسال‌شده از فرم تماس عمومی سایت</p>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium text-xs">نام فرستنده</th>
              <th class="p-4 font-medium text-xs">ایمیل / شماره</th>
              <th class="p-4 font-medium text-xs">موضوع</th>
              <th class="p-4 font-medium text-xs">وضعیت</th>
              <th class="p-4 font-medium text-xs">تاریخ</th>
              <th class="p-4 font-medium text-xs text-center">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contact in contacts.data" :key="contact.id" class="border-b border-slate-100 hover:bg-slate-50/70 transition" :class="{'bg-blue-50/30 font-medium': !contact.is_read}">
              <td class="p-4 text-sm text-slate-900">{{ contact.name }}</td>
              <td class="p-4">
                <div class="text-xs text-slate-700 font-mono">{{ contact.email }}</div>
                <div class="text-[11px] text-slate-400 font-mono mt-0.5" v-if="contact.phone">{{ contact.phone }}</div>
              </td>
              <td class="p-4 text-sm text-slate-800">{{ contact.subject || 'بدون موضوع' }}</td>
              <td class="p-4">
                <span v-if="!contact.is_read" class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded-full">جدید</span>
                <span v-else class="text-slate-400 text-xs">خوانده شده</span>
              </td>
              <td class="p-4 text-slate-500 text-xs font-mono">{{ new Date(contact.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4 text-center">
                <div class="inline-flex items-center gap-2">
                  <Link :href="route('admin.contacts.show', contact.id)" class="text-blue-600 hover:text-blue-800 text-xs font-bold bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg transition">
                    مشاهده
                  </Link>
                  <button
                    type="button"
                    @click="promptDeleteContact(contact)"
                    class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1 rounded hover:bg-red-50 transition cursor-pointer"
                  >
                    حذف
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="contacts.data.length === 0">
              <td colspan="6" class="p-12 text-center text-slate-400 text-sm">
                هیچ پیام تماسی ثبت نشده است.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Persian Pagination -->
      <Pagination
        :links="contacts.links || []"
        :from="contacts.from"
        :to="contacts.to"
        :total="contacts.total"
      />
    </div>

    <!-- Confirm Modal -->
    <ConfirmModal
      :show="showDeleteModal"
      title="حذف پیام تماس"
      :message="`آیا از حذف پیام تماس از طرف '${selectedContact?.name}' اطمینان دارید؟`"
      confirm-text="بله، حذف شود"
      cancel-text="انصراف"
      :loading="isDeleting"
      @confirm="confirmDeleteContact"
      @close="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';

defineProps({
  contacts: Object,
});

const showDeleteModal = ref(false);
const selectedContact = ref(null);
const isDeleting = ref(false);

const promptDeleteContact = (contact) => {
  selectedContact.value = contact;
  showDeleteModal.value = true;
};

const confirmDeleteContact = () => {
  if (!selectedContact.value || isDeleting.value) return;
  isDeleting.value = true;
  router.delete(`/admin/contacts/${selectedContact.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false;
      selectedContact.value = null;
    },
    onFinish: () => {
      isDeleting.value = false;
    },
  });
};
</script>
