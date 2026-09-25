<script setup>
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { CheckCircle2, AlertCircle, X } from 'lucide-vue-next';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success'); // 'success' | 'error'
let timer = null;

const dismiss = () => {
  show.value = false;
  if (timer) clearTimeout(timer);
};

const trigger = (msg, msgType = 'success') => {
  if (!msg) return;
  message.value = msg;
  type.value = msgType;
  show.value = true;

  if (timer) clearTimeout(timer);
  timer = setTimeout(() => {
    show.value = false;
  }, 5000);
};

// Watch for changes in flash props
watch(
  () => page.props.flash?.success,
  (val) => {
    if (val) trigger(val, 'success');
  }
);

watch(
  () => page.props.flash?.error,
  (val) => {
    if (val) trigger(val, 'error');
  }
);

onMounted(() => {
  if (page.props.flash?.success) {
    trigger(page.props.flash.success, 'success');
  } else if (page.props.flash?.error) {
    trigger(page.props.flash.error, 'error');
  }
});
</script>

<template>
  <Transition
    enter-active-class="transform ease-out duration-180 transition"
    enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:-translate-x-4"
    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
    leave-active-class="transition ease-in duration-140"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="show"
      class="fixed inset-x-4 top-4 z-[60] flex w-auto max-w-md items-start gap-3 rounded-xl border bg-white p-4 shadow-lg transition-all duration-180 sm:inset-x-auto sm:left-5 sm:top-5 sm:w-full"
      :class="type === 'success' 
        ? 'bg-white/95 border-emerald-200 text-slate-800 ring-1 ring-emerald-500/20 shadow-emerald-500/10' 
        : 'bg-white/95 border-rose-200 text-slate-800 ring-1 ring-rose-500/20 shadow-rose-500/10'"
      dir="rtl"
      :role="type === 'error' ? 'alert' : 'status'"
    >
      <div 
        class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
        :class="type === 'success' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'"
      >
        <CheckCircle2 v-if="type === 'success'" class="w-5 h-5" />
        <AlertCircle v-else class="w-5 h-5" />
      </div>

      <div class="flex-1 pt-1">
        <p class="text-xs font-bold" :class="type === 'success' ? 'text-emerald-700' : 'text-rose-700'">
          {{ type === 'success' ? 'عملیات موفق' : 'خطا در عملیات' }}
        </p>
        <p class="text-sm font-medium text-slate-700 mt-0.5 leading-snug">
          {{ message }}
        </p>
      </div>

      <button
        @click="dismiss"
        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100"
        aria-label="بستن اعلان"
      >
        <X class="w-4 h-4" />
      </button>
    </div>
  </Transition>
</template>
