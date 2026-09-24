<template>
  <AdminLayout>
    <Head title="ویرایش نمونه‌کار" />
    
    <div class="mb-6">
      <Link href="/admin/portfolios" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <h1 class="text-2xl font-bold text-slate-800">ویرایش نمونه‌کار: {{ portfolio.title }}</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm max-w-3xl">
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">عنوان</label>
            <input v-model="form.title" type="text" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">نامک (Slug)</label>
            <input v-model="form.slug" type="text" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" dir="ltr">
            <div v-if="form.errors.slug" class="text-red-500 text-sm mt-1">{{ form.errors.slug }}</div>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">توضیحات</label>
          <textarea v-model="form.description" rows="4" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
          <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">نام مشتری</label>
            <input v-model="form.client_name" type="text" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">دسته‌بندی</label>
            <input v-model="form.category" type="text" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <div v-if="form.errors.category" class="text-red-500 text-sm mt-1">{{ form.errors.category }}</div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">لینک پروژه (URL)</label>
            <input v-model="form.url" type="url" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" dir="ltr">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">تصویر (اختیاری)</label>
            <input type="file" @input="form.image = $event.target.files[0]" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 border">
            <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</div>
            <div v-if="portfolio.image" class="mt-2">
              <img :src="portfolio.image.startsWith('http') ? portfolio.image : `/storage/${portfolio.image}`" class="w-32 h-auto rounded border" alt="تصویر فعلی">
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input v-model="form.is_featured" type="checkbox" id="is_featured" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
          <label for="is_featured" class="text-sm text-slate-700">نمایش در صفحه اصلی (ویژه)</label>
        </div>

        <div class="pt-4 flex gap-3">
          <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
            ذخیره تغییرات
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  portfolio: Object,
});

// For inertia file uploads via PUT/PATCH, laravel requires method spoofing.
// We'll use POST and add _method='put'
const form = useForm({
  _method: 'put',
  title: props.portfolio.title,
  slug: props.portfolio.slug,
  description: props.portfolio.description,
  client_name: props.portfolio.client_name,
  category: props.portfolio.category,
  url: props.portfolio.url,
  is_featured: props.portfolio.is_featured,
  image: null,
});

const submit = () => {
  form.post(`/admin/portfolios/${props.portfolio.id}`);
};
</script>
