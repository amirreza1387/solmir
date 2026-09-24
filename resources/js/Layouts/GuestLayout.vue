<script setup>
import { Link } from '@inertiajs/vue3';
import { Sparkles, ArrowRight } from 'lucide-vue-next';
import FlashMessages from '@/Components/FlashMessages.vue';
</script>

<template>
  <div class="min-h-screen bg-slate-50 flex flex-col justify-center items-center p-4 relative overflow-hidden bg-radial-glow bg-dot-pattern" dir="rtl">
    <FlashMessages />
    <!-- Ambient glowing orbs -->
    <div class="absolute -top-32 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none animate-pulse-slow"></div>
    <div class="absolute -bottom-32 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>

    <!-- Brand Logo -->
    <div class="mb-8 text-center relative z-10">
      <Link href="/" class="inline-flex items-center gap-3 group">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-all">
          <Sparkles class="w-6 h-6 animate-pulse" />
        </div>
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
    <div class="w-full sm:max-w-md bg-white/90 backdrop-blur-xl rounded-3xl p-8 sm:p-10 shadow-2xl shadow-blue-500/5 border border-slate-200/90 relative z-10">
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
