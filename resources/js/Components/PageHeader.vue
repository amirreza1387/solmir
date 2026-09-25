<script setup>
defineProps({ title: { type: String, required: true }, description: { type: String, default: '' } });
</script>

<template>
  <div class="ui-page-header flex-col sm:flex-row sm:items-center">
    <div>
      <h1 class="ui-page-title">{{ title }}</h1>
      <p v-if="description" class="mt-1 text-sm leading-6 text-slate-600">{{ description }}</p>
    </div>
    <div v-if="$slots.actions" class="flex flex-wrap gap-3"><slot name="actions" /></div>
  </div>
</template>
