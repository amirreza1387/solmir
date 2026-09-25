<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Mail, Send, Loader2 } from 'lucide-vue-next';

defineProps({
  status: {
    type: String,
    default: null,
  },
});

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(route('password.email'));
};
</script>

<template>
  <GuestLayout>
    <SeoHead title="بازیابی رمز عبور" noindex />

    <div class="mb-6 text-center">
      <h2 class="text-2xl font-black text-slate-900 mb-1.5">بازیابی رمز عبور</h2>
      <p class="text-xs text-slate-500 leading-relaxed max-w-sm mx-auto">
        ایمیل خود را وارد کنید تا لینک اختصاصی تغییر رمز عبور برای شما ارسال گردد.
      </p>
    </div>

    <!-- Success Status Message -->
    <div v-if="status" class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-700">
      {{ status }}
    </div>

    <!-- Error Alert -->
    <div v-if="form.errors.email" class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs font-bold text-red-700">
      {{ form.errors.email }}
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="email" class="block font-bold text-xs text-slate-700 mb-1.5">آدرس ایمیل *</label>
        <div class="relative">
          <input
            id="email"
            type="email"
            v-model="form.email"
            required
            autofocus
            autocomplete="email"
            dir="ltr"
            placeholder="name@example.com"
            class="w-full px-4 py-3 pl-10 text-left rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
          />
          <Mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" aria-hidden="true" />
        </div>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer mt-4"
      >
        <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin ml-1" />
        <Send v-else class="w-4 h-4" />
        <span>{{ form.processing ? 'در حال ارسال لینک...' : 'ارسال لینک بازیابی رمز' }}</span>
      </button>

      <div class="text-center text-xs text-slate-600 pt-4 border-t border-slate-100">
        رمز عبور را به یاد آوردید؟
        <Link
          :href="route('login')"
          class="font-bold text-blue-600 hover:text-blue-700 mr-1 inline-flex items-center gap-1"
        >
          <span>ورود به حساب</span>
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
