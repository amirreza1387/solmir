<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import {
  PlusCircle,
  ArrowLeft,
  UploadCloud,
  Calendar,
  Coins,
  Laptop,
  Smartphone,
  Search,
  Palette,
  Code2,
  CheckCircle2,
  Sparkles,
  FileText,
  Trash2,
  Loader2,
  AlertCircle
} from 'lucide-vue-next';

const fileError = ref('');

const form = useForm({
  title: '',
  service_type: 'طراحی وب‌سایت شرکتی',
  description: '',
  budget_range: '۲۰ الی ۴۰ میلیون تومان',
  deadline: '',
  attachments: []
});

const formatFileSize = (bytes) => {
  if (!bytes) return '0 B';
  const k = 1024;
  const sizes = ['B', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
};

const handleFileUpload = (e) => {
  fileError.value = '';
  const selectedFiles = Array.from(e.target.files);
  const maxBytes = 10 * 1024 * 1024; // 10MB

  const oversized = selectedFiles.find(file => file.size > maxBytes);
  if (oversized) {
    fileError.value = `حجم فایل "${oversized.name}" بیشتر از حد مجاز ۱۰ مگابایت است.`;
    return;
  }

  const combined = [...form.attachments, ...selectedFiles];
  if (combined.length > 5) {
    fileError.value = 'حداکثر می‌توانید ۵ فایل ضمیمه کنید.';
    form.attachments = combined.slice(0, 5);
    return;
  }

  form.attachments = combined;
  // reset file input
  e.target.value = '';
};

const removeAttachment = (index) => {
  fileError.value = '';
  form.attachments.splice(index, 1);
};

const serviceOptions = [
  { name: 'طراحی وب‌سایت شرکتی', icon: Laptop, desc: 'معرفی خدمات و پرستیژ برند' },
  { name: 'فروشگاه اینترنتی جامع', icon: Sparkles, desc: 'اتصال به درگاه و فروش آنلاین' },
  { name: 'سامانه و وب‌اپلیکیشن اختصاصی', icon: Code2, desc: 'پنل کاربری و فرآیند سفارشی' },
  { name: 'طراحی رابط کاربری UI/UX', icon: Palette, desc: 'طراحی فیگما و پروتوتایپ' },
  { name: 'بهینه‌سازی سئو و سرعت', icon: Search, desc: 'رتبه برتر در موتورهای جستجو' },
  { name: 'اپلیکیشن موبایل و PWA', icon: Smartphone, desc: 'نسخه اختصاصی iOS و Android' },
];

const budgetOptions = [
  'زیر ۲۰ میلیون تومان',
  '۲۰ الی ۴۰ میلیون تومان',
  '۴۰ الی ۷۰ میلیون تومان',
  'بیش از ۷۰ میلیون تومان'
];

const query = new URLSearchParams(usePage().url.split('?')[1] || '');
const selectedService = query.get('service_type');
const selectedBudget = query.get('budget_range');
if (serviceOptions.some(option => option.name === selectedService)) {
  form.service_type = selectedService;
}
if (budgetOptions.includes(selectedBudget)) {
  form.budget_range = selectedBudget;
}
const estimateDetails = [
  query.get('estimate')?.slice(0, 80),
  query.get('design_level')?.slice(0, 40),
  query.get('add_ons')?.slice(0, 300),
].filter(Boolean);
if (serviceOptions.some(option => option.name === selectedService) && estimateDetails.length) {
  form.description = `برآورد اولیه ثبت‌شده در سایت:\nنوع پروژه: ${form.service_type}\nبرآورد هزینه و زمان: ${estimateDetails[0] || 'نیازمند بررسی'}\nسطح طراحی: ${estimateDetails[1] || 'مشخص نشده'}\nامکانات انتخابی: ${estimateDetails[2] || 'موردی انتخاب نشده'}\n\nتوضیحات تکمیلی پروژه:\n`;
}

const submit = () => {
  if (fileError.value) return;
  form.post(route('orders.store'), {
    preserveScroll: true,
  });
};
</script>

<template>
  <Head title="ثبت سفارش پروژه جدید | سلمیر" />

  <AppLayout>
    <div class="max-w-4xl mx-auto space-y-6">

      <!-- Top Title -->
      <div class="flex items-center justify-between">
        <div>
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100/70 text-blue-700 text-xs font-bold mb-2">
            <PlusCircle class="w-3.5 h-3.5" />
            <span>سفارش اختصاصی</span>
          </div>
          <h1 class="text-2xl font-black text-slate-900">ثبت سفارش پروژه جدید</h1>
          <p class="text-xs text-slate-500 mt-1">مشخصات اولیه پروژه خود را وارد کنید تا کارشناسان ما بررسی و زمان‌بندی را آغاز کنند.</p>
        </div>

        <Link
          :href="route('orders.index')"
          class="text-xs font-bold text-slate-600 hover:text-blue-600 bg-white border border-slate-200 px-4 py-2.5 rounded-xl transition flex items-center gap-1.5"
        >
          <span>مشاهده سفارشات من</span>
          <ArrowLeft class="w-3.5 h-3.5" />
        </Link>
      </div>

      <!-- Main Form Card -->
      <div v-if="estimateDetails.length" class="ui-card border-blue-200 bg-blue-50 p-5 text-sm text-blue-900" role="status">
        <h2 class="font-bold">مشخصات برآورد اولیه به فرم منتقل شد</h2>
        <p class="mt-1">جزئیات در بخش توضیحات قابل ویرایش است. هزینه و زمان پس از بررسی پروژه مشخص می‌شود.</p>
      </div>
      <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm">
        <form @submit.prevent="submit" class="space-y-8">

          <!-- 1. Service Type Selector -->
          <div>
            <label class="block text-sm font-bold text-slate-900 mb-3">
              ۱. نوع خدمت مورد نظر خود را انتخاب کنید:
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
              <button
                v-for="service in serviceOptions"
                :key="service.name"
                type="button"
                @click="form.service_type = service.name"
                class="p-4 rounded-2xl border text-right transition-all flex flex-col justify-between"
                :class="form.service_type === service.name
                  ? 'border-blue-600 bg-blue-50/70 text-blue-900 ring-2 ring-blue-500/20 shadow-xs'
                  : 'border-slate-200 text-slate-700 hover:bg-slate-50'"
              >
                <div class="flex items-center justify-between mb-2">
                  <component :is="service.icon" class="w-5 h-5" :class="form.service_type === service.name ? 'text-blue-600' : 'text-slate-400'" />
                  <CheckCircle2 v-if="form.service_type === service.name" class="w-4 h-4 text-blue-600" />
                </div>
                <div class="font-bold text-xs sm:text-sm">{{ service.name }}</div>
                <div class="text-[11px] text-slate-400 mt-1">{{ service.desc }}</div>
              </button>
            </div>
            <span v-if="form.errors.service_type" class="text-xs text-red-500 mt-1 block">{{ form.errors.service_type }}</span>
          </div>

          <!-- 2. Project Title -->
          <div>
            <label for="title" class="block text-sm font-bold text-slate-900 mb-2">
              ۲. عنوان یا نام پروژه *
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              placeholder="مثال: طراحی وب‌سایت فروش قطعات خودرو آرتین"
              class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
            />
            <span v-if="form.errors.title" class="text-xs text-red-500 mt-1 block">{{ form.errors.title }}</span>
          </div>

          <!-- 3. Description -->
          <div>
            <label for="description" class="block text-sm font-bold text-slate-900 mb-2">
              ۳. توضیحات و نیازمندی‌های پروژه *
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="5"
              required
              placeholder="هدف پروژه، امکانات مورد نیاز، رنگ‌های سازمانی، وب‌سایت‌های مرجع و هر آنچه که به ما در درک بهتر پروژه کمک می‌کند را بنویسید..."
              class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition resize-none"
            ></textarea>
            <span v-if="form.errors.description" class="text-xs text-red-500 mt-1 block">{{ form.errors.description }}</span>
          </div>

          <!-- 4. Budget Range & Deadline -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-bold text-slate-900 mb-2 flex items-center gap-1.5">
                <Coins class="w-4 h-4 text-blue-600" />
                <span>محدوده بودجه تقریبی</span>
              </label>
              <select
                v-model="form.budget_range"
                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition bg-white"
              >
                <option v-for="b in budgetOptions" :key="b" :value="b">{{ b }}</option>
              </select>
            </div>

            <div>
              <label for="deadline" class="block text-sm font-bold text-slate-900 mb-2 flex items-center gap-1.5">
                <Calendar class="w-4 h-4 text-blue-600" />
                <span>تاریخ یا مهلت مدنظر (اختیاری)</span>
              </label>
              <input
                id="deadline"
                v-model="form.deadline"
                type="date"
                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition bg-white"
              />
            </div>
          </div>

          <!-- 5. Attachments Dropzone -->
          <div>
            <label class="block text-sm font-bold text-slate-900 mb-2">
              ۵. فایل‌های پیوست، مستندات، یا لوگو (اختیاری)
            </label>
            <div class="border-2 border-dashed border-slate-300 hover:border-blue-400 rounded-2xl p-6 text-center bg-slate-50 transition cursor-pointer relative">
              <input
                type="file"
                multiple
                @change="handleFileUpload"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
              />
              <UploadCloud class="w-8 h-8 text-blue-500 mx-auto mb-2" />
              <div class="text-xs font-bold text-slate-700">کلیک کنید یا فایل‌ها را اینجا بکشید</div>
              <div class="text-[11px] text-slate-400 mt-1">فرمت‌های مجاز: PDF, PNG, JPG, ZIP, DOCX (حداکثر ۵ فایل، هرکدام حداکثر ۱۰ مگابایت)</div>
            </div>

            <!-- Client-side File Error Alert -->
            <div v-if="fileError" class="mt-3 p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl flex items-center gap-2">
              <AlertCircle class="w-4 h-4 shrink-0 text-red-600" />
              <span>{{ fileError }}</span>
            </div>

            <!-- Server-side File Errors -->
            <div v-if="form.errors.attachments" class="mt-2 text-xs text-red-500">
              {{ form.errors.attachments }}
            </div>
            <template v-for="(error, key) in form.errors" :key="key">
              <div v-if="key.startsWith('attachments.')" class="mt-1 text-xs text-red-500">
                {{ error }}
              </div>
            </template>

            <!-- Selected Files List -->
            <div v-if="form.attachments && form.attachments.length > 0" class="mt-4 space-y-2">
              <div class="text-xs font-bold text-slate-700 mb-2">فایل‌های انتخاب‌شده ({{ form.attachments.length }} از ۵):</div>
              <div
                v-for="(file, index) in form.attachments"
                :key="index"
                class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs"
              >
                <div class="flex items-center gap-2 min-w-0">
                  <FileText class="w-4 h-4 text-blue-600 shrink-0" />
                  <span class="font-medium text-slate-800 truncate">{{ file.name }}</span>
                  <span class="text-[10px] font-mono text-slate-400 shrink-0 bg-slate-200/70 px-1.5 py-0.5 rounded">
                    {{ formatFileSize(file.size) }}
                  </span>
                </div>

                <button
                  type="button"
                  @click="removeAttachment(index)"
                  class="text-red-500 hover:text-red-700 p-1 rounded-lg hover:bg-red-50 transition cursor-pointer shrink-0"
                  title="حذف فایل"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <button
              type="submit"
              :disabled="form.processing || !!fileError"
              class="ui-button ui-button-primary disabled:opacity-50"
            >
              <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin ml-1.5" />
              <PlusCircle v-else class="w-4 h-4" />
              <span>{{ form.processing ? 'در حال ارسال و ثبت سفارش...' : 'تایید و ثبت نهایی سفارش' }}</span>
            </button>

            <span class="text-xs text-slate-400">پس از ثبت، تاییدیه در پنل برای شما نمایش می‌یابد</span>
          </div>

        </form>
      </div>

    </div>
  </AppLayout>
</template>
