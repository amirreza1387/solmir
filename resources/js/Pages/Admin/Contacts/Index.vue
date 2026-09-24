<template>
  <AdminLayout>
    <Head title="پیام‌های تماس" />
    
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-slate-800">پیام‌های تماس با ما</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium">نام</th>
              <th class="p-4 font-medium">ایمیل / شماره</th>
              <th class="p-4 font-medium">موضوع</th>
              <th class="p-4 font-medium">وضعیت</th>
              <th class="p-4 font-medium">تاریخ</th>
              <th class="p-4 font-medium">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contact in contacts.data" :key="contact.id" class="border-b border-slate-100 hover:bg-slate-50" :class="{'bg-slate-50 font-medium': !contact.is_read}">
              <td class="p-4">{{ contact.name }}</td>
              <td class="p-4">
                <div class="text-sm">{{ contact.email }}</div>
                <div class="text-xs text-slate-500" v-if="contact.phone">{{ contact.phone }}</div>
              </td>
              <td class="p-4">{{ contact.subject || 'بدون موضوع' }}</td>
              <td class="p-4">
                <span v-if="!contact.is_read" class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">جدید</span>
                <span v-else class="text-slate-400 text-sm">خوانده شده</span>
              </td>
              <td class="p-4 text-slate-600 text-sm">{{ new Date(contact.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4 flex items-center gap-3">
                <Link :href="`/admin/contacts/${contact.id}`" class="text-blue-600 hover:text-blue-800 text-sm">
                  مشاهده
                </Link>
                <button @click="deleteContact(contact)" class="text-red-500 hover:text-red-700 text-sm">
                  حذف
                </button>
              </td>
            </tr>
            <tr v-if="contacts.data.length === 0">
              <td colspan="6" class="p-4 text-center text-slate-500">پیامی یافت نشد.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="p-4 border-t border-slate-200 flex justify-center gap-1" v-if="contacts.links && contacts.links.length > 3">
        <template v-for="(link, i) in contacts.links" :key="i">
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
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  contacts: Object,
});

const deleteContact = (contact) => {
  if (confirm('آیا از حذف این پیام اطمینان دارید؟')) {
    router.delete(`/admin/contacts/${contact.id}`);
  }
};
</script>
