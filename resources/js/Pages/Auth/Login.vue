<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, LogIn, Sparkles, ShieldCheck } from 'lucide-vue-next';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};

const fillAdminCredentials = () => {
  form.email = 'admin@solmir.com';
  form.password = 'password';
};
</script>

<template>
  <GuestLayout>
    <Head title="ورود به حساب کاربری | سلمیر" />

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
        <label for="email" class="block font-bold text-sm text-slate-700 mb-1.5">ایمیل یا شماره موبایل</label>
        <div class="relative">
          <input
            id="email"
            type="text"
            v-model="form.email"
            required
            autofocus
            dir="ltr"
            placeholder="ایمیل یا ۰۹۱۲۳۴۵۶۷۸۹"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition text-right"
          />
          <Mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
        </div>
      </div>

      <div>
        <label for="password" class="block font-bold text-sm text-slate-700 mb-1.5">رمز عبور</label>
        <div class="relative">
          <input
            id="password"
            type="password"
            v-model="form.password"
            required
            dir="ltr"
            placeholder="••••••••"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition text-right"
          />
          <Lock class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
        </div>
        <span v-if="form.errors.password" class="text-xs text-red-500 mt-1 block">{{ form.errors.password }}</span>
      </div>

      <div class="flex items-center justify-between pt-1">
        <label class="flex items-center gap-2 cursor-pointer">
          <input 
            type="checkbox" 
            name="remember" 
            v-model="form.remember" 
            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4" 
          />
          <span class="text-xs text-slate-600 font-medium">مرا به خاطر بسپار</span>
        </label>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/25 hover:shadow-lg transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer mt-4"
      >
        <LogIn class="w-4 h-4" />
        <span>{{ form.processing ? 'در حال ورود...' : 'ورود به حساب کاربری' }}</span>
      </button>

      <!-- Demo Credentials Quick Pill -->
      <div class="pt-4 border-t border-slate-100 text-center">
        <button 
          type="button" 
          @click="fillAdminCredentials"
          class="text-[11px] font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 py-1.5 px-3 rounded-lg transition inline-flex items-center gap-1.5"
        >
          <ShieldCheck class="w-3.5 h-3.5 text-blue-600" />
          <span>تکمیل خودکار اطلاعات ادمین دمو</span>
        </button>
      </div>

      <div class="text-center text-xs text-slate-600 pt-2">
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
