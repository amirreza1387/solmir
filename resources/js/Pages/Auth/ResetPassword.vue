<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';
import PasswordStrengthMeter from '@/Components/PasswordStrengthMeter.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, KeyRound, Eye, EyeOff, Loader2 } from 'lucide-vue-next';

const props = defineProps({
  email: {
    type: String,
    default: '',
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email || '',
  password: '',
  password_confirmation: '',
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const submit = () => {
  form.post(route('password.update'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <GuestLayout>
    <SeoHead title="تنظیم رمز عبور جدید" noindex />

    <div class="mb-6 text-center">
      <h2 class="text-2xl font-black text-slate-900 mb-1.5">تعیین رمز عبور جدید</h2>
      <p class="text-xs text-slate-500">لطفاً رمز عبور جدید خود را وارد و تایید نمایید.</p>
    </div>

    <!-- Error Alert -->
    <div v-if="form.errors.email || form.errors.token" class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs font-bold text-red-700">
      {{ form.errors.email || form.errors.token }}
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="email" class="block font-bold text-xs text-slate-700 mb-1.5">آدرس ایمیل</label>
        <div class="relative">
          <input
            id="email"
            type="email"
            v-model="form.email"
            required
            autocomplete="email"
            dir="ltr"
            placeholder="name@example.com"
            class="w-full px-4 py-3 pl-10 text-left rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <Mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" aria-hidden="true" />
        </div>
      </div>

      <div>
        <label for="password" class="block font-bold text-xs text-slate-700 mb-1.5">رمز عبور جدید (حداقل ۸ کاراکتر) *</label>
        <div class="relative">
          <input
            id="password"
            :type="showPassword ? 'text' : 'password'"
            v-model="form.password"
            required
            autofocus
            autocomplete="new-password"
            placeholder="حداقل ۸ کاراکتر"
            class="w-full px-4 py-3 pl-20 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="p-1 text-slate-400 hover:text-slate-600 transition cursor-pointer"
              :aria-label="showPassword ? 'مخفی کردن رمز عبور' : 'نمایش رمز عبور'"
            >
              <EyeOff v-if="showPassword" class="w-4 h-4" />
              <Eye v-else class="w-4 h-4" />
            </button>
            <Lock class="w-4 h-4 text-slate-400" aria-hidden="true" />
          </div>
        </div>
        <span v-if="form.errors.password" class="text-xs text-red-500 mt-1 block font-medium">{{ form.errors.password }}</span>
      </div>

      <div>
        <label for="password_confirmation" class="block font-bold text-xs text-slate-700 mb-1.5">تکرار رمز عبور جدید *</label>
        <div class="relative">
          <input
            id="password_confirmation"
            :type="showConfirmPassword ? 'text' : 'password'"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
            placeholder="تکرار رمز عبور"
            class="w-full px-4 py-3 pl-20 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
            <button
              type="button"
              @click="showConfirmPassword = !showConfirmPassword"
              class="p-1 text-slate-400 hover:text-slate-600 transition cursor-pointer"
              :aria-label="showConfirmPassword ? 'مخفی کردن تکرار رمز' : 'نمایش تکرار رمز'"
            >
              <EyeOff v-if="showConfirmPassword" class="w-4 h-4" />
              <Eye v-else class="w-4 h-4" />
            </button>
            <Lock class="w-4 h-4 text-slate-400" aria-hidden="true" />
          </div>
        </div>

        <!-- Animated Password Strength & Criteria Meter -->
        <PasswordStrengthMeter
          :password="form.password"
          :confirmation="form.password_confirmation"
        />
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer mt-4"
      >
        <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin ml-1" />
        <KeyRound v-else class="w-4 h-4" />
        <span>{{ form.processing ? 'در حال ذخیره...' : 'تغییر رمز عبور و ورود' }}</span>
      </button>

      <div class="text-center text-xs text-slate-600 pt-4 border-t border-slate-100">
        <Link
          :href="route('login')"
          class="font-bold text-blue-600 hover:text-blue-700 mr-1"
        >
          بازگشت به صفحه ورود
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
