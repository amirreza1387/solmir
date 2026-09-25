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
  <article class="ui-card group flex h-full flex-col overflow-hidden transition-all duration-200 hover:border-blue-300 hover:shadow-lg">
    <!-- Mini browser mock header on project card -->
    <div class="flex items-center justify-between border-b border-slate-200/80 bg-slate-100/70 px-3 py-2 text-[10px] text-slate-500">
      <div class="flex items-center gap-1.5">
        <span class="h-2 w-2 rounded-full bg-slate-300 transition-colors group-hover:bg-red-400"></span>
        <span class="h-2 w-2 rounded-full bg-slate-300 transition-colors group-hover:bg-amber-400"></span>
        <span class="h-2 w-2 rounded-full bg-slate-300 transition-colors group-hover:bg-emerald-400"></span>
      </div>
      <span class="font-mono text-[9px] text-slate-400 opacity-80">{{ portfolio.category || 'web-app' }}</span>
    </div>

    <div :class="featured ? 'aspect-[21/9]' : 'aspect-[16/10]'" class="overflow-hidden bg-slate-100 relative">
      <img v-if="portfolio.image" :src="imageUrl(portfolio.image)" :alt="`نمای پروژه ${portfolio.title}`" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-103" loading="lazy" />
      <div v-else class="flex h-full flex-col items-center justify-center gap-3 bg-slate-100 p-6 text-center text-slate-500">
        <ImageOff class="h-8 w-8 text-slate-400" aria-hidden="true" />
        <span class="text-sm">تصویر پروژه موجود نیست</span>
      </div>
    </div>
    <div class="flex flex-1 flex-col p-6">
      <div class="mb-2 flex items-center justify-between gap-2">
        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700">{{ portfolio.category }}</span>
        <span v-if="portfolio.client_name" class="text-xs text-slate-500">{{ portfolio.client_name }}</span>
      </div>
      <h3 :class="featured ? 'text-2xl' : 'text-xl'" class="mb-2 font-bold leading-snug text-slate-900 group-hover:text-blue-900 transition-colors">{{ portfolio.title }}</h3>
      <p class="line-clamp-3 text-sm leading-7 text-slate-600">{{ portfolio.description }}</p>
      <div class="mt-auto flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5">
        <Link :href="route('portfolio.show', portfolio.slug)" class="inline-flex min-h-11 items-center gap-2 text-sm font-bold text-blue-700 group-hover:text-blue-800">
          مشاهده پروژه <ArrowLeft class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1.5" aria-hidden="true" />
        </Link>
        <a v-if="portfolio.url" :href="portfolio.url" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-11 items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-blue-700">
          سایت زنده <ExternalLink class="h-4 w-4" aria-hidden="true" />
        </a>
      </div>
    </div>
  </article>
</template>
