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
  <article class="ui-card ui-service-card group relative overflow-hidden transition-all duration-200 hover:border-blue-300 hover:shadow-lg">
    <!-- Subtle technical corner dot pattern -->
    <div class="pointer-events-none absolute -top-8 -left-8 h-24 w-24 bg-tech-grid opacity-30 transition-opacity duration-200 group-hover:opacity-70"></div>
    
    <div class="relative z-10">
      <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl border border-blue-100 bg-blue-50/90 text-blue-700 shadow-2xs transition-all duration-200 group-hover:scale-105 group-hover:border-blue-600 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-md">
        <component :is="icon" class="h-6 w-6 transition-transform duration-200" aria-hidden="true" />
      </div>
      <h3 class="mb-3 text-xl font-bold leading-snug text-slate-900 group-hover:text-blue-900 transition-colors">{{ service.title }}</h3>
      <p class="line-clamp-4 text-sm leading-7 text-slate-600">{{ service.description }}</p>
    </div>
    <div class="relative z-10 mt-6 border-t border-slate-100 pt-4">
      <Link :href="route('services.show', service.slug)" class="inline-flex min-h-11 items-center gap-2 text-sm font-bold text-blue-700 group-hover:text-blue-800">
        مشاهده خدمت <ArrowLeft class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1.5" aria-hidden="true" />
      </Link>
    </div>
  </article>
</template>
