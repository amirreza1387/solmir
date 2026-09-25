<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';
import PasswordStrengthMeter from '@/Components/PasswordStrengthMeter.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { User, Mail, Phone, Lock, UserPlus, Eye, EyeOff, Loader2 } from 'lucide-vue-next';

const form = useForm({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <GuestLayout>
    <SeoHead title="ثبت‌نام در پلتفرم سلمیر" noindex />

    <div class="mb-6 text-center">
      <h2 class="text-2xl font-black text-slate-900 mb-1.5">ایجاد حساب کاربری</h2>
      <p class="text-xs text-slate-500">برای ثبت سفارش و استفاده از خدمات پشتیبانی، ثبت‌نام کنید.</p>
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="name" class="block font-bold text-xs text-slate-700 mb-1.5">نام و نام خانوادگی *</label>
        <div class="relative">
          <input
            id="name"
            type="text"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
            placeholder="مثال: رضا صادقی"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <User class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" aria-hidden="true" />
        </div>
        <span v-if="form.errors.name" class="text-xs text-red-500 mt-1 block font-medium">{{ form.errors.name }}</span>
      </div>

      <div>
        <label for="email" class="block font-bold text-xs text-slate-700 mb-1.5">آدرس ایمیل *</label>
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
        <span v-if="form.errors.email" class="text-xs text-red-500 mt-1 block font-medium">{{ form.errors.email }}</span>
      </div>

      <div>
        <label for="phone" class="block font-bold text-xs text-slate-700 mb-1.5">شماره موبایل *</label>
        <div class="relative">
          <input
            id="phone"
            type="tel"
            v-model="form.phone"
            required
            autocomplete="tel"
            dir="ltr"
            placeholder="09123456789"
            class="w-full px-4 py-3 pl-10 text-left rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <Phone class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" aria-hidden="true" />
        </div>
        <span v-if="form.errors.phone" class="text-xs text-red-500 mt-1 block font-medium">{{ form.errors.phone }}</span>
      </div>

      <div>
        <label for="password" class="block font-bold text-xs text-slate-700 mb-1.5">رمز عبور (حداقل ۸ کاراکتر) *</label>
        <div class="relative">
          <input
            id="password"
            :type="showPassword ? 'text' : 'password'"
            v-model="form.password"
            required
            autocomplete="new-password"
            placeholder="••••••••"
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
        <label for="password_confirmation" class="block font-bold text-xs text-slate-700 mb-1.5">تکرار رمز عبور *</label>
        <div class="relative">
          <input
            id="password_confirmation"
            :type="showConfirmPassword ? 'text' : 'password'"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
            placeholder="••••••••"
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
        <span v-if="form.errors.password_confirmation" class="text-xs text-red-500 mt-1 block font-medium">{{ form.errors.password_confirmation }}</span>

        <!-- Animated Password Strength & Criteria Meter -->
        <PasswordStrengthMeter
          :password="form.password"
          :confirmation="form.password_confirmation"
        />
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer mt-6"
      >
        <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin ml-1" />
        <UserPlus v-else class="w-4 h-4" />
        <span>{{ form.processing ? 'در حال ایجاد حساب...' : 'تکمیل ثبت‌نام و ورود' }}</span>
      </button>

      <div class="text-center text-xs text-slate-600 pt-3">
        قبلاً حساب ایجاد کرده‌اید؟
        <Link
          :href="route('login')"
          class="font-bold text-blue-600 hover:text-blue-700 mr-1"
        >
          ورود به حساب
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
