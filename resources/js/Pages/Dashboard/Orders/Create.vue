<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
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
  Sparkles 
} from 'lucide-vue-next';

const form = useForm({
  title: '',
  service_type: 'طراحی وب‌سایت شرکتی',
  description: '',
  budget_range: '۲۰ الی ۴۰ میلیون تومان',
  deadline: '',
  attachments: []
});

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

const submit = () => {
  form.post(route('orders.store'), {
    preserveScroll: true,
  });
};

const handleFileUpload = (e) => {
  form.attachments = Array.from(e.target.files);
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
              <div class="text-[11px] text-slate-400 mt-1">فرمت‌های مجاز: PDF, PNG, JPG, ZIP, DOCX (حداکثر ۲۰ مگابایت)</div>
              
              <div v-if="form.attachments && form.attachments.length > 0" class="mt-4 pt-3 border-t border-slate-200">
                <span class="text-xs font-bold text-emerald-600">
                  {{ form.attachments.length }} فایل انتخاب شده است
                </span>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <button 
              type="submit"
              :disabled="form.processing"
              class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm shadow-md shadow-blue-500/25 hover:shadow-lg transition disabled:opacity-50 flex items-center gap-2 cursor-pointer"
            >
              <PlusCircle class="w-4 h-4" />
              <span>{{ form.processing ? 'در حال ثبت سفارش...' : 'تایید و ثبت نهایی سفارش' }}</span>
            </button>

            <span class="text-xs text-slate-400">پس از ثبت، تاییدیه در پنل برای شما نمایش می‌یابد</span>
          </div>

        </form>
      </div>

    </div>
  </AppLayout>
</template>
