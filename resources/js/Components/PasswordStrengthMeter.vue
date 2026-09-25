<script setup>
import { computed } from 'vue';
import {
  Check,
  Circle,
  Sparkles,
  ShieldCheck,
  ShieldAlert,
  ShieldX,
  Shield
} from 'lucide-vue-next';

const props = defineProps({
  password: {
    type: String,
    default: '',
  },
  confirmation: {
    type: String,
    default: null,
  },
  showCriteria: {
    type: Boolean,
    default: true,
  },
});

// Criteria checks matching Laravel's Password::min(8)->letters()->mixedCase()->numbers()->symbols()
const hasMinLength = computed(() => (props.password || '').length >= 8);
const hasMixedCase = computed(() => /[a-z]/.test(props.password || '') && /[A-Z]/.test(props.password || ''));
const hasNumber = computed(() => /[0-9]/.test(props.password || ''));
const hasSymbol = computed(() => /[^A-Za-z0-9]/.test(props.password || ''));

const criteriaList = computed(() => [
  { id: 'length', label: 'حداقل ۸ کاراکتر', met: hasMinLength.value },
  { id: 'mixed', label: 'حروف بزرگ و کوچک', met: hasMixedCase.value },
  { id: 'number', label: 'شامل اعداد (۰-۹)', met: hasNumber.value },
  { id: 'symbol', label: 'شامل نمادها (!@#$)', met: hasSymbol.value },
]);

const score = computed(() => {
  if (!props.password) return 0;
  let s = 0;
  if (hasMinLength.value) s++;
  if (hasMixedCase.value) s++;
  if (hasNumber.value) s++;
  if (hasSymbol.value) s++;
  return s;
});

const isConfirmed = computed(() => {
  if (props.confirmation === null || props.confirmation === undefined) return null;
  if (!props.confirmation) return null;
  return props.password === props.confirmation;
});

const strengthInfo = computed(() => {
  switch (score.value) {
    case 1:
      return {
        label: 'بسیار ضعیف',
        color: 'bg-rose-500',
        textColor: 'text-rose-600',
        borderColor: 'border-rose-200',
        bgColor: 'bg-rose-50',
        width: 'w-1/4',
        icon: ShieldX,
        hint: 'از ترکیب حروف بزرگ، اعداد و نمادها استفاده فرمایید.',
      };
    case 2:
      return {
        label: 'متوسط',
        color: 'bg-amber-500',
        textColor: 'text-amber-600',
        borderColor: 'border-amber-200',
        bgColor: 'bg-amber-50',
        width: 'w-2/4',
        icon: ShieldAlert,
        hint: 'افزودن نماد یا حروف بزرگ امنیت را دوچندان می‌کند.',
      };
    case 3:
      return {
        label: 'خوب و امن',
        color: 'bg-blue-600',
        textColor: 'text-blue-600',
        borderColor: 'border-blue-200',
        bgColor: 'bg-blue-50',
        width: 'w-3/4',
        icon: Shield,
        hint: 'عالی است؛ با افزودن یک نماد دیگر رمزتان نفوذناپذیر می‌شود.',
      };
    case 4:
      return {
        label: 'فوق‌العاده قوی و نفوذناپذیر',
        color: 'bg-emerald-500',
        textColor: 'text-emerald-600',
        borderColor: 'border-emerald-200',
        bgColor: 'bg-emerald-50',
        width: 'w-full',
        icon: ShieldCheck,
        hint: 'رمز عبور شما تمام استانداردهای امنیتی سازمانی را داراست.',
      };
    default:
      return {
        label: 'رمز عبور را وارد کنید',
        color: 'bg-slate-200',
        textColor: 'text-slate-400',
        borderColor: 'border-slate-200',
        bgColor: 'bg-slate-50',
        width: 'w-0',
        icon: Shield,
        hint: 'رمز عبور باید حداقل ۸ کاراکتر و ترکیبی از حروف، اعداد و نمادها باشد.',
      };
  }
});
</script>

<template>
  <Transition
    enter-active-class="transition-all duration-300 ease-out"
    enter-from-class="opacity-0 -translate-y-2 max-h-0"
    enter-to-class="opacity-100 translate-y-0 max-h-96"
    leave-active-class="transition-all duration-200 ease-in"
    leave-from-class="opacity-100 translate-y-0 max-h-96"
    leave-to-class="opacity-0 -translate-y-2 max-h-0"
  >
    <div v-if="password && password.length > 0" class="mt-3 space-y-3 overflow-hidden">
      <!-- Strength Header & Segmented Progress Bar -->
      <div class="p-3.5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs transition-all duration-300">
        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center gap-1.5">
            <component
              :is="strengthInfo.icon"
              class="w-4 h-4 transition-colors duration-300"
              :class="strengthInfo.textColor"
            />
            <span class="text-xs font-bold text-slate-700">قدرت رمز عبور:</span>
            <span
              class="text-xs font-black transition-all duration-300"
              :class="strengthInfo.textColor"
            >
              {{ strengthInfo.label }}
            </span>
          </div>

          <!-- Celebration sparkles indicator for level 4 -->
          <div
            v-if="score === 4"
            class="flex items-center gap-1 text-[11px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 animate-bounce"
          >
            <Sparkles class="w-3.5 h-3.5 text-emerald-500" />
            <span>امنیت ۱۰۰٪</span>
          </div>
          <div v-else class="text-[11px] font-mono font-bold text-slate-400">
            {{ score }} / ۴
          </div>
        </div>

        <!-- 4-Segment Animated Progress Track -->
        <div class="grid grid-cols-4 gap-1.5 h-2 bg-slate-100 p-0.5 rounded-full overflow-hidden">
          <div
            v-for="index in 4"
            :key="index"
            class="h-full rounded-full transition-all duration-500 ease-out"
            :class="index <= score ? strengthInfo.color : 'bg-transparent'"
          />
        </div>

        <!-- Real-time helpful hint -->
        <p class="text-[11px] text-slate-500 mt-2 leading-relaxed">
          {{ strengthInfo.hint }}
        </p>
      </div>

      <!-- Animated Criteria Badges -->
      <div v-if="showCriteria" class="grid grid-cols-2 gap-2 text-xs">
        <div
          v-for="criterion in criteriaList"
          :key="criterion.id"
          class="flex items-center gap-2 p-2 rounded-xl border transition-all duration-300"
          :class="criterion.met
            ? 'bg-emerald-50/70 border-emerald-200/80 text-emerald-800 font-bold shadow-2xs scale-[1.01]'
            : 'bg-slate-50/70 border-slate-200 text-slate-500'"
        >
          <div
            class="w-4 h-4 rounded-full flex items-center justify-center shrink-0 transition-transform duration-300"
            :class="criterion.met ? 'bg-emerald-500 text-white scale-110' : 'bg-slate-200 text-slate-400'"
          >
            <Check v-if="criterion.met" class="w-2.5 h-2.5 stroke-[3]" />
            <Circle v-else class="w-1.5 h-1.5 fill-current" />
          </div>
          <span class="text-[11px] select-none">{{ criterion.label }}</span>
        </div>
      </div>

      <!-- Password Confirmation Live Match Badge -->
      <div
        v-if="confirmation !== null && confirmation !== undefined && confirmation.length > 0"
        class="flex items-center gap-2 p-2.5 rounded-xl border text-xs transition-all duration-300"
        :class="isConfirmed
          ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
          : 'bg-amber-50 border-amber-200 text-amber-800'"
      >
        <div
          class="w-4 h-4 rounded-full flex items-center justify-center shrink-0"
          :class="isConfirmed ? 'bg-emerald-500 text-white' : 'bg-amber-500 text-white'"
        >
          <Check v-if="isConfirmed" class="w-2.5 h-2.5 stroke-[3]" />
          <span v-else class="text-[10px] font-black">!</span>
        </div>
        <span class="text-[11px] font-bold">
          {{ isConfirmed ? 'رمز عبور و تکرار آن کاملاً مطابقت دارند.' : 'رمز عبور با تکرار آن یکسان نیست.' }}
        </span>
      </div>
    </div>
  </Transition>
</template>
