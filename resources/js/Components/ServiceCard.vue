<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Code2, Headphones, Laptop, Palette, Search, Smartphone } from 'lucide-vue-next';

const props = defineProps({ service: { type: Object, required: true } });
const icon = computed(() => {
  const name = `${props.service.slug || ''} ${props.service.title || ''}`.toLowerCase();
  if (/seo|جستجو|سئو/.test(name)) return Search;
  if (/ui|ux|رابط|design/.test(name) && !/web-design/.test(name)) return Palette;
  if (/mobile|موبایل|اپلیکیشن/.test(name)) return Smartphone;
  if (/support|پشتیبانی/.test(name)) return Headphones;
  if (/brand|برند/.test(name)) return Palette;
  if (/web|وب|سایت/.test(name)) return Laptop;
  return Code2;
});
</script>

<template>
  <article class="ui-card ui-service-card group">
    <div>
      <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
        <component :is="icon" class="h-6 w-6" aria-hidden="true" />
      </div>
      <h3 class="mb-3 text-xl font-bold leading-snug text-slate-900">{{ service.title }}</h3>
      <p class="line-clamp-4 text-sm leading-7 text-slate-600">{{ service.description }}</p>
    </div>
    <div class="mt-6 border-t border-slate-100 pt-4">
      <Link :href="route('services.show', service.slug)" class="inline-flex min-h-11 items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800">
        مشاهده خدمت <ArrowLeft class="h-4 w-4" aria-hidden="true" />
      </Link>
    </div>
  </article>
</template>
