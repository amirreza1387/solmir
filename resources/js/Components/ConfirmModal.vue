<script setup>
import { onMounted, onUnmounted, watch } from 'vue';
import { AlertTriangle, Loader2 } from 'lucide-vue-next';

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: 'تایید عملیات',
  },
  message: {
    type: String,
    default: 'آیا از انجام این عملیات اطمینان دارید؟ این عمل ممکن است غیرقابل بازگشت باشد.',
  },
  confirmText: {
    type: String,
    default: 'بله، حذف شود',
  },
  cancelText: {
    type: String,
    default: 'انصراف',
  },
  destructive: {
    type: Boolean,
    default: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['confirm', 'close']);

const onKeydown = (e) => {
  if (e.key === 'Escape' && props.show && !props.loading) {
    emit('close');
  }
};

watch(
  () => props.show,
  (val) => {
    if (val) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  }
);

onMounted(() => {
  window.addEventListener('keydown', onKeydown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', onKeydown);
  document.body.style.overflow = '';
});
</script>

<template>
  <Teleport to="body">
    <div
      v-if="show"
      class="fixed inset-0 z-50 overflow-y-auto"
      aria-labelledby="modal-title"
      role="dialog"
      aria-modal="true"
      dir="rtl"
    >
      <!-- Backdrop -->
      <div
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
        @click="!loading && emit('close')"
      ></div>

      <!-- Modal Dialog -->
      <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
          class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200"
          @click.stop
        >
          <div class="bg-white p-6 sm:p-7">
            <div class="flex items-start gap-4">
              <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl"
                :class="destructive ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600'"
              >
                <AlertTriangle class="h-5 w-5" />
              </div>
              <div class="mt-0.5 text-right flex-1">
                <h3 id="modal-title" class="text-base font-black text-slate-900">
                  {{ title }}
                </h3>
                <div class="mt-2">
                  <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    {{ message }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
            <button
              type="button"
              :disabled="loading"
              @click="emit('confirm')"
              class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-xs transition disabled:opacity-50 cursor-pointer"
              :class="destructive
                ? 'bg-red-600 hover:bg-red-700 text-white shadow-red-500/20'
                : 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-500/20'"
            >
              <Loader2 v-if="loading" class="w-4 h-4 ml-1.5 animate-spin" />
              <span>{{ confirmText }}</span>
            </button>

            <button
              type="button"
              :disabled="loading"
              @click="emit('close')"
              class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-200/60 bg-white border border-slate-200 shadow-xs transition disabled:opacity-50 cursor-pointer"
            >
              {{ cancelText }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>
