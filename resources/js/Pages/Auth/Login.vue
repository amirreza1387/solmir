<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, LogIn, Eye, EyeOff, Loader2 } from 'lucide-vue-next';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const showPassword = ref(false);

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <GuestLayout>
    <SeoHead title="ورود به حساب کاربری" noindex />

    <div class="mb-6 text-center">
      <h2 class="text-2xl font-black text-slate-900 mb-1.5">خوش آمدید!</h2>
      <p class="text-xs text-slate-500">برای پیگیری سفارشات و تیکت‌ها وارد حساب خود شوید.</p>
    </div>

    <!-- Error Alert -->
    <div v-if="form.errors.email" class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs font-bold text-red-700">
      {{ form.errors.email }}
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="email" class="block font-bold text-xs text-slate-700 mb-1.5">ایمیل یا شماره موبایل *</label>
        <div class="relative">
          <input
            id="email"
            type="text"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
            placeholder="ایمیل یا ۰۹۱۲۳۴۵۶۷۸۹"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <Mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" aria-hidden="true" />
        </div>
      </div>

      <div>
        <label for="password" class="block font-bold text-xs text-slate-700 mb-1.5">رمز عبور *</label>
        <div class="relative">
          <input
            id="password"
            :type="showPassword ? 'text' : 'password'"
            v-model="form.password"
            required
            autocomplete="current-password"
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

      <div class="flex items-center justify-between pt-1">
        <label class="flex items-center gap-2 cursor-pointer select-none">
          <input
            type="checkbox"
            name="remember"
            v-model="form.remember"
            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer"
          />
          <span class="text-xs text-slate-600 font-medium">مرا به خاطر بسپار</span>
        </label>

        <Link
          :href="route('password.request')"
          class="text-xs font-bold text-blue-600 hover:text-blue-700 transition"
        >
          رمز عبور را فراموش کرده‌اید؟
        </Link>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer mt-4"
      >
        <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin ml-1" />
        <LogIn v-else class="w-4 h-4" />
        <span>{{ form.processing ? 'در حال ورود...' : 'ورود به حساب کاربری' }}</span>
      </button>

      <div class="text-center text-xs text-slate-600 pt-4 border-t border-slate-100">
        حساب کاربری ندارید؟
        <Link
          :href="route('register')"
          class="font-bold text-blue-600 hover:text-blue-700 mr-1"
        >
          ثبت‌نام رایگان
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
