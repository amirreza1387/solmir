<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronRight, ChevronLeft } from 'lucide-vue-next';

const props = defineProps({
  links: {
    type: Array,
    required: true,
  },
  from: {
    type: [Number, String],
    default: null,
  },
  to: {
    type: [Number, String],
    default: null,
  },
  total: {
    type: [Number, String],
    default: null,
  },
});

const toFaDigit = (val) => {
  if (val === null || val === undefined) return '';
  return String(val).replace(/[0-9]/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[d]);
};

const cleanLabel = (label) => {
  if (!label) return '';
  const text = label.replace(/&laquo;|&raquo;/g, '').trim();
  if (text.toLowerCase().includes('previous') || text === 'قبلی') {
    return 'قبلی';
  }
  if (text.toLowerCase().includes('next') || text === 'بعدی') {
    return 'بعدی';
  }
  return toFaDigit(text);
};

const isPrevious = (label) => {
  return label && (label.toLowerCase().includes('previous') || label.includes('&laquo;') || label === 'قبلی');
};

const isNext = (label) => {
  return label && (label.toLowerCase().includes('next') || label.includes('&raquo;') || label === 'بعدی');
};

const shouldRender = computed(() => props.links && props.links.length > 3);
</script>

<template>
  <div v-if="shouldRender || total !== null" class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-3 bg-white border-t border-slate-200 text-xs text-slate-500">
    <!-- Summary Info -->
    <div v-if="total !== null && total > 0" class="font-medium text-slate-600">
      نمایش 
      <span class="font-bold text-slate-900 font-mono">{{ toFaDigit(from || 1) }}</span>
      تا 
      <span class="font-bold text-slate-900 font-mono">{{ toFaDigit(to || total) }}</span>
      از مجموع 
      <span class="font-bold text-slate-900 font-mono">{{ toFaDigit(total) }}</span>
      مورد
    </div>
    <div v-else></div>

    <!-- Navigation Links -->
    <nav v-if="shouldRender" class="flex items-center gap-1" aria-label="صفحه‌بندی">
      <template v-for="(link, key) in links" :key="key">
        <span
          v-if="!link.url"
          class="inline-flex items-center justify-center min-w-8 h-8 px-2.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-400 cursor-not-allowed select-none text-xs"
          aria-disabled="true"
        >
          <ChevronRight v-if="isPrevious(link.label)" class="w-3.5 h-3.5 ml-1" />
          <span>{{ cleanLabel(link.label) }}</span>
          <ChevronLeft v-if="isNext(link.label)" class="w-3.5 h-3.5 mr-1" />
        </span>

        <Link
          v-else
          :href="link.url"
          :preserve-scroll="true"
          :preserve-state="true"
          class="inline-flex items-center justify-center min-w-8 h-8 px-2.5 rounded-lg text-xs font-bold transition-colors select-none"
          :class="link.active
            ? 'bg-blue-600 text-white shadow-xs pointer-events-none'
            : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 hover:text-blue-600'"
          :aria-current="link.active ? 'page' : undefined"
        >
          <ChevronRight v-if="isPrevious(link.label)" class="w-3.5 h-3.5 ml-1" />
          <span>{{ cleanLabel(link.label) }}</span>
          <ChevronLeft v-if="isNext(link.label)" class="w-3.5 h-3.5 mr-1" />
        </Link>
      </template>
    </nav>
  </div>
</template>
