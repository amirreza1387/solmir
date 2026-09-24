<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import FlashMessages from '@/Components/FlashMessages.vue';
</script>

<template>
  <div class="min-h-screen flex flex-col font-sans text-slate-800 bg-slate-50" dir="rtl">
    <FlashMessages />
    <Header />
    <main class="flex-grow">
      <slot />
    </main>
    <Footer />
  </div>
</template>
