<script setup>
import { computed } from 'vue';

const props = defineProps({ status: { type: String, required: true }, kind: { type: String, default: 'order' } });
const definitions = {
  order: {
    pending: ['در انتظار بررسی', 'bg-amber-50 text-amber-800'],
    confirmed: ['تایید شده', 'bg-blue-50 text-blue-800'],
    in_progress: ['در حال انجام', 'bg-indigo-50 text-indigo-800'],
    completed: ['تکمیل شده', 'bg-emerald-50 text-emerald-800'],
    cancelled: ['لغو شده', 'bg-rose-50 text-rose-800'],
  },
  ticket: {
    open: ['باز', 'bg-amber-50 text-amber-800'],
    in_progress: ['در حال بررسی', 'bg-blue-50 text-blue-800'],
    answered: ['پاسخ داده شده', 'bg-purple-50 text-purple-800'],
    closed: ['بسته شده', 'bg-slate-100 text-slate-700'],
  },
  priority: {
    low: ['کم', 'bg-slate-100 text-slate-700'],
    medium: ['متوسط', 'bg-blue-50 text-blue-800'],
    high: ['زیاد', 'bg-orange-50 text-orange-800'],
    urgent: ['فوری', 'bg-rose-50 text-rose-800'],
  },
};
const definition = computed(() => definitions[props.kind]?.[props.status] || [props.status, 'bg-slate-100 text-slate-700']);
</script>

<template>
  <span class="ui-badge whitespace-nowrap" :class="definition[1]">{{ definition[0] }}</span>
</template>
