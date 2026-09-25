<template>
  <AdminLayout>
    <Head title="افزودن خدمت" />
    
    <div class="mb-6">
      <Link href="/admin/services" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <h1 class="text-2xl font-bold text-slate-800">افزودن خدمت جدید</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm max-w-3xl">
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="service-title" class="block text-sm font-medium text-slate-700 mb-1">عنوان</label>
            <input id="service-title" v-model="form.title" type="text" @input="generateSlug" class="ui-field">
            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
          </div>
          <div>
            <label for="service-slug" class="block text-sm font-medium text-slate-700 mb-1">نامک (Slug)</label>
            <input id="service-slug" v-model="form.slug" type="text" class="ui-field" dir="ltr">
            <div v-if="form.errors.slug" class="text-red-500 text-sm mt-1">{{ form.errors.slug }}</div>
          </div>
        </div>

        <div>
          <label for="service-description" class="block text-sm font-medium text-slate-700 mb-1">توضیحات</label>
          <textarea id="service-description" v-model="form.description" rows="4" class="ui-field"></textarea>
          <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="service-icon" class="block text-sm font-medium text-slate-700 mb-1">آیکون (نام کلاس یا SVG)</label>
            <input id="service-icon" v-model="form.icon" type="text" class="ui-field" dir="ltr">
          </div>
          <div>
            <label for="service-sort_order" class="block text-sm font-medium text-slate-700 mb-1">ترتیب نمایش</label>
            <input id="service-sort_order" v-model="form.sort_order" type="number" class="ui-field" dir="ltr">
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
          <label for="is_active" class="text-sm text-slate-700">این خدمت فعال باشد</label>
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
  icon: '',
  sort_order: 0,
  is_active: true,
});

const generateSlug = () => {
  if (!form.slug || form.title.length > 0) {
    form.slug = form.title.toLowerCase().replace(/[^a-z0-9\u0600-\u06FF]+/g, '-').replace(/(^-|-$)+/g, '');
  }
};

const submit = () => {
  form.post('/admin/services');
};
</script>
