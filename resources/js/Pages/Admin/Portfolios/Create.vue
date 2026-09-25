<template>
  <AdminLayout>
    <Head title="افزودن نمونه‌کار" />
    
    <div class="mb-6">
      <Link href="/admin/portfolios" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <h1 class="text-2xl font-bold text-slate-800">افزودن نمونه‌کار جدید</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm max-w-3xl">
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="portfolio-title" class="block text-sm font-medium text-slate-700 mb-1">عنوان</label>
            <input id="portfolio-title" v-model="form.title" type="text" @input="generateSlug" class="ui-field">
            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
          </div>
          <div>
            <label for="portfolio-slug" class="block text-sm font-medium text-slate-700 mb-1">نامک (Slug)</label>
            <input id="portfolio-slug" v-model="form.slug" type="text" class="ui-field" dir="ltr">
            <div v-if="form.errors.slug" class="text-red-500 text-sm mt-1">{{ form.errors.slug }}</div>
          </div>
        </div>

        <div>
          <label for="portfolio-description" class="block text-sm font-medium text-slate-700 mb-1">توضیحات</label>
          <textarea id="portfolio-description" v-model="form.description" rows="4" class="ui-field"></textarea>
          <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="portfolio-client_name" class="block text-sm font-medium text-slate-700 mb-1">نام مشتری</label>
            <input id="portfolio-client_name" v-model="form.client_name" type="text" class="ui-field">
          </div>
          <div>
            <label for="portfolio-category" class="block text-sm font-medium text-slate-700 mb-1">دسته‌بندی</label>
            <input id="portfolio-category" v-model="form.category" type="text" class="ui-field">
            <div v-if="form.errors.category" class="text-red-500 text-sm mt-1">{{ form.errors.category }}</div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="portfolio-url" class="block text-sm font-medium text-slate-700 mb-1">لینک پروژه (URL)</label>
            <input id="portfolio-url" v-model="form.url" type="url" class="ui-field" dir="ltr">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">تصویر</label>
            <input type="file" @input="form.image = $event.target.files[0]" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 border">
            <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input v-model="form.is_featured" type="checkbox" id="is_featured" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
          <label for="is_featured" class="text-sm text-slate-700">نمایش در صفحه اصلی (ویژه)</label>
        </div>

        <div class="pt-4 flex gap-3">
          <button type="submit" :disabled="form.processing" class="ui-button ui-button-primary">
            ذخیره
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const form = useForm({
  title: '',
  slug: '',
  description: '',
  client_name: '',
  category: '',
  url: '',
  is_featured: false,
  image: null,
});

const generateSlug = () => {
  if (!form.slug || form.title.length > 0) {
    form.slug = form.title.toLowerCase().replace(/[^a-z0-9\u0600-\u06FF]+/g, '-').replace(/(^-|-$)+/g, '');
  }
};

const submit = () => {
  form.post('/admin/portfolios');
};
</script>
