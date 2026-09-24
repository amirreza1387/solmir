<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { User, Mail, Phone, Lock, UserPlus } from 'lucide-vue-next';

const form = useForm({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="ثبت‌نام در پلتفرم سلمیر" />

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
            placeholder="مثال: رضا صادقی"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <User class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
        </div>
        <span v-if="form.errors.name" class="text-xs text-red-500 mt-1 block">{{ form.errors.name }}</span>
      </div>

      <div>
        <label for="email" class="block font-bold text-xs text-slate-700 mb-1.5">آدرس ایمیل *</label>
        <div class="relative">
          <input
            id="email"
            type="email"
            v-model="form.email"
            required
            dir="ltr"
            placeholder="name@example.com"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition text-right"
          />
          <Mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
        </div>
        <span v-if="form.errors.email" class="text-xs text-red-500 mt-1 block">{{ form.errors.email }}</span>
      </div>

      <div>
        <label for="phone" class="block font-bold text-xs text-slate-700 mb-1.5">شماره موبایل *</label>
        <div class="relative">
          <input
            id="phone"
            type="tel"
            v-model="form.phone"
            required
            dir="ltr"
            placeholder="09123456789"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition text-right"
          />
          <Phone class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
        </div>
        <span v-if="form.errors.phone" class="text-xs text-red-500 mt-1 block">{{ form.errors.phone }}</span>
      </div>

      <div>
        <label for="password" class="block font-bold text-xs text-slate-700 mb-1.5">رمز عبور (حداقل ۸ کاراکتر) *</label>
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

      <div>
        <label for="password_confirmation" class="block font-bold text-xs text-slate-700 mb-1.5">تکرار رمز عبور *</label>
        <div class="relative">
          <input
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            required
            dir="ltr"
            placeholder="••••••••"
            class="w-full px-4 py-3 pl-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition text-right"
          />
          <Lock class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
        </div>
        <span v-if="form.errors.password_confirmation" class="text-xs text-red-500 mt-1 block">{{ form.errors.password_confirmation }}</span>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/25 hover:shadow-lg transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer mt-6"
      >
        <UserPlus class="w-4 h-4" />
        <span>{{ form.processing ? 'در حال ثبت‌نام...' : 'تکمیل ثبت‌نام و ورود' }}</span>
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
