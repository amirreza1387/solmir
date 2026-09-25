<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
  User, 
  Mail, 
  Phone, 
  Lock, 
  Save, 
  KeyRound, 
  Calendar, 
  ShieldCheck,
  Eye,
  EyeOff,
  Loader2
} from 'lucide-vue-next';

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const profileForm = useForm({
  name: props.user.name || '',
  email: props.user.email || '',
  phone: props.user.phone || '',
});

const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const showCurrentPassword = ref(false);
const showNewPassword = ref(false);
const showConfirmPassword = ref(false);

const updateProfile = () => {
  profileForm.patch(route('profile.update'), {
    preserveScroll: true,
  });
};

const updatePassword = () => {
  passwordForm.put(route('profile.password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      passwordForm.reset();
    },
  });
};
</script>

<template>
  <Head title="پروفایل کاربری | سلمیر" />

  <AppLayout>
    <div class="max-w-4xl mx-auto space-y-8">
      
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100/70 text-blue-700 text-xs font-bold mb-2">
            <User class="w-3.5 h-3.5" />
            <span>تنظیمات حساب</span>
          </div>
          <h1 class="text-2xl font-black text-slate-900">پروفایل کاربری</h1>
          <p class="text-xs text-slate-500 mt-1">مدیریت اطلاعات هویتی و تغییر کلمه عبور حساب کاربری شما</p>
        </div>

        <div class="flex items-center gap-3 text-xs text-slate-500 bg-white border border-slate-200/80 px-4 py-2.5 rounded-2xl shadow-xs self-start sm:self-auto">
          <Calendar class="w-4 h-4 text-blue-600" />
          <span>عضویت از: </span>
          <span class="font-bold text-slate-700">{{ new Date(user.created_at).toLocaleDateString('fa-IR') }}</span>
        </div>
      </div>

      <!-- Section 1: Profile Information -->
      <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
          <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
            <User class="w-5 h-5" />
          </div>
          <div>
            <h2 class="text-base font-black text-slate-900">اطلاعات هویتی و تماس</h2>
            <p class="text-xs text-slate-400 mt-0.5">نام، ایمیل و شماره موبایل ثبت‌شده در سامانه سلمیر</p>
          </div>
        </div>

        <form @submit.prevent="updateProfile" class="space-y-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="sm:col-span-2">
              <label for="profile_name" class="block text-xs font-bold text-slate-700 mb-2">نام و نام‌خانوادگی *</label>
              <div class="relative">
                <input
                  id="profile_name"
                  v-model="profileForm.name"
                  type="text"
                  required
                  placeholder="مثال: علی رضایی"
                  class="w-full px-4 py-3 pr-10 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
                />
                <User class="w-4 h-4 text-slate-400 absolute right-3.5 top-3.5" />
              </div>
              <span v-if="profileForm.errors.name" class="text-xs text-red-500 mt-1.5 block font-medium">{{ profileForm.errors.name }}</span>
            </div>

            <!-- Email -->
            <div>
              <label for="profile_email" class="block text-xs font-bold text-slate-700 mb-2">آدرس ایمیل *</label>
              <div class="relative">
                <input
                  id="profile_email"
                  v-model="profileForm.email"
                  type="email"
                  required
                  dir="ltr"
                  placeholder="example@mail.com"
                  class="w-full px-4 py-3 pl-10 text-left rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
                />
                <Mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
              </div>
              <span v-if="profileForm.errors.email" class="text-xs text-red-500 mt-1.5 block font-medium">{{ profileForm.errors.email }}</span>
            </div>

            <!-- Phone -->
            <div>
              <label for="profile_phone" class="block text-xs font-bold text-slate-700 mb-2">شماره موبایل *</label>
              <div class="relative">
                <input
                  id="profile_phone"
                  v-model="profileForm.phone"
                  type="text"
                  required
                  dir="ltr"
                  placeholder="09123456789"
                  class="w-full px-4 py-3 pl-10 text-left rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
                />
                <Phone class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
              </div>
              <span v-if="profileForm.errors.phone" class="text-xs text-red-500 mt-1.5 block font-medium">{{ profileForm.errors.phone }}</span>
            </div>
          </div>

          <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <button
              type="submit"
              :disabled="profileForm.processing"
              class="ui-button ui-button-primary disabled:opacity-50"
            >
              <Loader2 v-if="profileForm.processing" class="w-4 h-4 animate-spin ml-1" />
              <Save v-else class="w-4 h-4" />
              <span>{{ profileForm.processing ? 'در حال ذخیره‌سازی...' : 'ذخیره تغییرات مشخصات' }}</span>
            </button>
            <span v-if="profileForm.recentlySuccessful" class="text-xs font-bold text-emerald-600 animate-pulse">
              تغییرات با موفقیت ذخیره شد
            </span>
          </div>
        </form>
      </div>

      <!-- Section 2: Change Password -->
      <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
          <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
            <KeyRound class="w-5 h-5" />
          </div>
          <div>
            <h2 class="text-base font-black text-slate-900">امنیت و تغییر کلمه عبور</h2>
            <p class="text-xs text-slate-400 mt-0.5">برای ارتقای امنیت حساب خود، از کلمات عبور پیچیده استفاده کنید</p>
          </div>
        </div>

        <form @submit.prevent="updatePassword" class="space-y-6">
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Current Password -->
            <div>
              <label for="current_password" class="block text-xs font-bold text-slate-700 mb-2">کلمه عبور فعلی *</label>
              <div class="relative">
                <input
                  id="current_password"
                  v-model="passwordForm.current_password"
                  :type="showCurrentPassword ? 'text' : 'password'"
                  required
                  autocomplete="current-password"
                  placeholder="••••••••"
                  class="w-full px-4 py-3 pl-20 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
                />
                <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                  <button
                    type="button"
                    @click="showCurrentPassword = !showCurrentPassword"
                    class="p-1 text-slate-400 hover:text-slate-600 transition cursor-pointer"
                    :aria-label="showCurrentPassword ? 'مخفی کردن رمز عبور' : 'نمایش رمز عبور'"
                  >
                    <EyeOff v-if="showCurrentPassword" class="w-4 h-4" />
                    <Eye v-else class="w-4 h-4" />
                  </button>
                  <Lock class="w-4 h-4 text-slate-400" aria-hidden="true" />
                </div>
              </div>
              <span v-if="passwordForm.errors.current_password" class="text-xs text-red-500 mt-1.5 block font-medium">{{ passwordForm.errors.current_password }}</span>
            </div>

            <!-- New Password -->
            <div>
              <label for="new_password" class="block text-xs font-bold text-slate-700 mb-2">کلمه عبور جدید *</label>
              <div class="relative">
                <input
                  id="new_password"
                  v-model="passwordForm.password"
                  :type="showNewPassword ? 'text' : 'password'"
                  required
                  autocomplete="new-password"
                  placeholder="حداقل ۸ کاراکتر"
                  class="w-full px-4 py-3 pl-20 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
                />
                <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                  <button
                    type="button"
                    @click="showNewPassword = !showNewPassword"
                    class="p-1 text-slate-400 hover:text-slate-600 transition cursor-pointer"
                    :aria-label="showNewPassword ? 'مخفی کردن رمز عبور' : 'نمایش رمز عبور'"
                  >
                    <EyeOff v-if="showNewPassword" class="w-4 h-4" />
                    <Eye v-else class="w-4 h-4" />
                  </button>
                  <Lock class="w-4 h-4 text-slate-400" aria-hidden="true" />
                </div>
              </div>
              <span v-if="passwordForm.errors.password" class="text-xs text-red-500 mt-1.5 block font-medium">{{ passwordForm.errors.password }}</span>
            </div>

            <!-- Confirm New Password -->
            <div>
              <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-2">تکرار کلمه عبور جدید *</label>
              <div class="relative">
                <input
                  id="password_confirmation"
                  v-model="passwordForm.password_confirmation"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  required
                  autocomplete="new-password"
                  placeholder="تکرار کلمه عبور"
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
              <span v-if="passwordForm.errors.password_confirmation" class="text-xs text-red-500 mt-1.5 block font-medium">{{ passwordForm.errors.password_confirmation }}</span>
            </div>
          </div>

          <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <button
              type="submit"
              :disabled="passwordForm.processing"
              class="ui-button ui-button-secondary disabled:opacity-50"
            >
              <Loader2 v-if="passwordForm.processing" class="w-4 h-4 animate-spin ml-1" />
              <KeyRound v-else class="w-4 h-4" />
              <span>{{ passwordForm.processing ? 'در حال ثبت...' : 'تغییر و بروزرسانی کلمه عبور' }}</span>
            </button>
            <span v-if="passwordForm.recentlySuccessful" class="text-xs font-bold text-emerald-600 animate-pulse">
              کلمه عبور با موفقیت تغییر یافت
            </span>
          </div>
        </form>
      </div>

    </div>
  </AppLayout>
</template>
