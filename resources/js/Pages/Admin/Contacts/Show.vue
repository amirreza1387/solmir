<template>
  <AdminLayout>
    <Head title="مشاهده پیام" />
    
    <div class="mb-6">
      <Link href="/admin/contacts" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">مشاهده پیام</h1>
        <button @click="deleteContact" class="px-4 py-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-sm">
          حذف پیام
        </button>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm max-w-3xl">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 mb-6 pb-6 border-b border-slate-100">
        <div>
          <span class="text-slate-500 text-sm block mb-1">فرستنده</span>
          <div class="font-medium text-slate-800">{{ contact.name }}</div>
        </div>
        <div>
          <span class="text-slate-500 text-sm block mb-1">تاریخ ارسال</span>
          <div class="font-medium text-slate-800" dir="ltr">{{ new Date(contact.created_at).toLocaleString('fa-IR') }}</div>
        </div>
        <div>
          <span class="text-slate-500 text-sm block mb-1">ایمیل</span>
          <div class="font-medium text-slate-800">
            <a :href="`mailto:${contact.email}`" class="text-blue-600 hover:underline">{{ contact.email }}</a>
          </div>
        </div>
        <div>
          <span class="text-slate-500 text-sm block mb-1">شماره تماس</span>
          <div class="font-medium text-slate-800" dir="ltr">{{ contact.phone || '---' }}</div>
        </div>
      </div>

      <div class="mb-4">
        <span class="text-slate-500 text-sm block mb-1">موضوع</span>
        <div class="font-bold text-lg text-slate-800">{{ contact.subject || 'بدون موضوع' }}</div>
      </div>

      <div>
        <span class="text-slate-500 text-sm block mb-2">متن پیام</span>
        <div class="bg-slate-50 p-5 rounded-lg text-slate-700 whitespace-pre-wrap leading-loose">
          {{ contact.message }}
        </div>
      </div>
      
      <div class="mt-8 flex gap-3">
        <a :href="`mailto:${contact.email}`" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          پاسخ از طریق ایمیل
        </a>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  contact: Object,
});

const deleteContact = () => {
  if (confirm('آیا از حذف این پیام اطمینان دارید؟')) {
    router.delete(`/admin/contacts/${props.contact.id}`);
  }
};
</script>
