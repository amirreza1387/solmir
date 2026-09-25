<script setup>
defineProps({ title: { type: String, required: true }, description: { type: String, default: '' } });
</script>

<template>
  <div class="ui-card ui-empty">
    <h2 class="text-lg font-bold text-slate-900">{{ title }}</h2>
    <p v-if="description" class="mx-auto mt-2 max-w-md text-sm leading-7">{{ description }}</p>
    <div v-if="$slots.action" class="mt-5"><slot name="action" /></div>
  </div>
</template>
