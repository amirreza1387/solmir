<script setup>
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, ExternalLink, ImageOff } from 'lucide-vue-next';

defineProps({
  portfolio: { type: Object, required: true },
  featured: { type: Boolean, default: false },
});

const imageUrl = (image) => image?.startsWith('http') ? image : `/storage/${image}`;
</script>

<template>
  <article class="ui-card group flex h-full flex-col overflow-hidden">
    <div :class="featured ? 'aspect-[21/9]' : 'aspect-[16/10]'" class="overflow-hidden bg-slate-100">
      <img v-if="portfolio.image" :src="imageUrl(portfolio.image)" :alt="`نمای پروژه ${portfolio.title}`" class="h-full w-full object-cover transition-transform duration-180 group-hover:scale-[1.02]" loading="lazy" />
      <div v-else class="flex h-full flex-col items-center justify-center gap-3 bg-slate-100 p-6 text-center text-slate-500">
        <ImageOff class="h-8 w-8 text-slate-400" aria-hidden="true" />
        <span class="text-sm">تصویر پروژه موجود نیست</span>
      </div>
    </div>
    <div class="flex flex-1 flex-col p-6">
      <p class="mb-2 text-xs font-semibold text-blue-700">{{ portfolio.category }}</p>
      <h3 :class="featured ? 'text-2xl' : 'text-xl'" class="mb-2 font-bold leading-snug text-slate-900">{{ portfolio.title }}</h3>
      <p v-if="portfolio.client_name" class="mb-3 text-sm text-slate-600">{{ portfolio.client_name }}</p>
      <p class="line-clamp-3 text-sm leading-7 text-slate-600">{{ portfolio.description }}</p>
      <div class="mt-auto flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5">
        <Link :href="route('portfolio.show', portfolio.slug)" class="inline-flex min-h-11 items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800">
          مشاهده پروژه <ArrowLeft class="h-4 w-4" aria-hidden="true" />
        </Link>
        <a v-if="portfolio.url" :href="portfolio.url" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-11 items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-blue-700">
          سایت زنده <ExternalLink class="h-4 w-4" aria-hidden="true" />
        </a>
      </div>
    </div>
  </article>
</template>
