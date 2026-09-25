<script setup>
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
import FlashMessages from '@/Components/FlashMessages.vue';
</script>

<template>
  <div class="min-h-screen bg-canvas flex flex-col justify-center items-center p-4" dir="rtl">
    <FlashMessages />
    <!-- Brand Logo -->
    <div class="mb-8 text-center relative z-10">
      <Link href="/" class="inline-flex items-center gap-3 group">
        <img 
          src="/apple-touch-icon.png" 
          alt="لوگوی سلمیر" 
          class="w-12 h-12 rounded-xl object-contain shadow-xs group-hover:scale-105 transition-transform" 
          width="48" 
          height="48" 
        />
        <div class="text-right">
          <span class="text-3xl font-black tracking-tight text-slate-900 group-hover:text-blue-600 transition-colors block">
            سلمیر
          </span>
          <span class="text-[10px] text-blue-600 font-bold tracking-widest uppercase block -mt-1">
            Solmir Digital Agency
          </span>
        </div>
      </Link>
    </div>

    <!-- Form Card -->
    <div class="ui-card w-full sm:max-w-md p-6 sm:p-10 relative z-10">
      <slot />
    </div>

    <!-- Return to Home link -->
    <div class="mt-6 text-center relative z-10">
      <Link href="/" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-blue-600 transition">
        <span>بازگشت به صفحه اصلی سایت</span>
        <ArrowRight class="w-3.5 h-3.5" />
      </Link>
    </div>
  </div>
</template>
