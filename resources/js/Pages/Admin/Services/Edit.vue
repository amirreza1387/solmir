<template>
  <AdminLayout>
    <Head title="ویرایش خدمت" />
    
    <div class="mb-6">
      <Link href="/admin/services" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <h1 class="text-2xl font-bold text-slate-800">ویرایش خدمت: {{ service.title }}</h1>
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
            <label class="block text-sm font-medium text-slate-700 mb-1">آیکون (نام کلاس یا SVG)</label>
            <input v-model="form.icon" type="text" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" dir="ltr">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">ترتیب نمایش</label>
            <input v-model="form.sort_order" type="number" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" dir="ltr">
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
          <label for="is_active" class="text-sm text-slate-700">این خدمت فعال باشد</label>
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
  service: Object,
});

const form = useForm({
  title: props.service.title,
  slug: props.service.slug,
  description: props.service.description,
  icon: props.service.icon || '',
  sort_order: props.service.sort_order,
  is_active: props.service.is_active,
});

const submit = () => {
  form.put(`/admin/services/${props.service.id}`);
};
</script>
