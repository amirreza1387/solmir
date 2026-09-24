<script setup>
import { computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  Mail, 
  Phone, 
  MapPin, 
  Send, 
  Clock, 
  CheckCircle2, 
  Sparkles, 
  MessageSquare,
  HelpCircle
} from 'lucide-vue-next';

const page = usePage();
const successMessage = computed(() => page.props.flash?.success);

const form = useForm({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
});

const submit = () => {
  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <Head title="تماس با ما | مشاوره رایگان طراحی وب سلمیر" />
  
  <PublicLayout>
    <!-- Header -->
    <div class="relative py-20 bg-radial-glow bg-dot-pattern border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-100/80 text-blue-700 text-xs font-bold mb-4">
          <MessageSquare class="w-4 h-4" />
          <span>ارتباط مستقیم با کارشناسان</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 mb-4">
          بیایید درباره پروژه شما صحبت کنیم
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-xl mx-auto leading-relaxed">
          سوالی دارید یا به دنبال برآورد دقیق ایده خود هستید؟ فرم زیر را ارسال کنید یا مستقیماً تماس بگیرید.
        </p>
      </div>
    </div>

    <!-- Main Content -->
    <div class="py-20 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
          
          <!-- Contact Info Sidebar (1 col) -->
          <div class="space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
              <h3 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">
                راه‌های ارتباطی
              </h3>

              <div class="space-y-5">
                <div class="flex items-start gap-3.5">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <Phone class="w-5 h-5" />
                  </div>
                  <div>
                    <div class="text-xs text-slate-400 font-medium">تماس تلفنی مستقیم</div>
                    <a href="tel:02188990011" class="text-slate-900 font-mono font-bold text-sm hover:text-blue-600 transition dir-ltr inline-block">
                      ۰۲۱ - ۸۸۹۹۰۰۱۱
                    </a>
                  </div>
                </div>

                <div class="flex items-start gap-3.5">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <Mail class="w-5 h-5" />
                  </div>
                  <div>
                    <div class="text-xs text-slate-400 font-medium">ایمیل کاری و رسمی</div>
                    <a href="mailto:info@solmir.com" class="text-slate-900 font-mono font-bold text-sm hover:text-blue-600 transition dir-ltr inline-block">
                      info@solmir.com
                    </a>
                  </div>
                </div>

                <div class="flex items-start gap-3.5">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <MapPin class="w-5 h-5" />
                  </div>
                  <div>
                    <div class="text-xs text-slate-400 font-medium">آدرس دفتر مرکزی</div>
                    <p class="text-slate-800 text-xs sm:text-sm leading-relaxed mt-0.5">
                      تهران، خیابان ولیعصر، برج فناوری و نوآوری، طبقه ۶
                    </p>
                  </div>
                </div>

                <div class="flex items-start gap-3.5">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <Clock class="w-5 h-5" />
                  </div>
                  <div>
                    <div class="text-xs text-slate-400 font-medium">ساعات پاسخگویی حضوری و تلفنی</div>
                    <p class="text-slate-800 text-xs sm:text-sm leading-relaxed mt-0.5">
                      شنبه تا چهارشنبه: ۹:۰۰ الی ۱۸:۰۰<br />
                      پشتیبانی تیکتینگ برای کاربران: ۲۴/۷
                    </p>
                  </div>
                </div>
              </div>

              <!-- Quick Chat / Support Link -->
              <div class="pt-4 border-t border-slate-100 bg-slate-50 -mx-8 -mb-8 p-6 rounded-b-3xl">
                <div class="text-xs font-bold text-slate-700 mb-1">کاربر ثبت‌نام شده هستید؟</div>
                <p class="text-[11px] text-slate-500 mb-3">برای پاسخگویی سریع‌تر از سیستم تیکتینگ استفاده فرمایید.</p>
                <Link 
                  :href="route('tickets.create')" 
                  class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1"
                >
                  ارسال تیکت در پنل کاربری
                  <Send class="w-3 h-3" />
                </Link>
              </div>
            </div>
          </div>

          <!-- Contact Form (2 cols) -->
          <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-sm">
              <h3 class="text-2xl font-black text-slate-900 mb-2">
                ارسال پیام یا درخواست مشاوره
              </h3>
              <p class="text-slate-500 text-sm mb-8">
                فرم زیر را تکمیل کنید، کارشناسان ما ظرف کمتر از ۴ ساعت کاری با شما تماس می‌گیرند.
              </p>

              <!-- Success Alert -->
              <div 
                v-if="successMessage" 
                class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 text-sm"
              >
                <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
                <span>{{ successMessage }}</span>
              </div>

              <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">نام و نام خانوادگی *</label>
                    <input 
                      v-model="form.name"
                      type="text" 
                      required
                      placeholder="مثال: علی احمدی"
                      class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
                    />
                    <span v-if="form.errors.name" class="text-xs text-red-500 mt-1 block">{{ form.errors.name }}</span>
                  </div>

                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">شماره تماس / موبایل *</label>
                    <input 
                      v-model="form.phone"
                      type="tel" 
                      dir="ltr"
                      placeholder="09123456789"
                      class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition text-right"
                    />
                    <span v-if="form.errors.phone" class="text-xs text-red-500 mt-1 block">{{ form.errors.phone }}</span>
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">آدرس ایمیل *</label>
                    <input 
                      v-model="form.email"
                      type="email" 
                      required
                      dir="ltr"
                      placeholder="name@example.com"
                      class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition text-right"
                    />
                    <span v-if="form.errors.email" class="text-xs text-red-500 mt-1 block">{{ form.errors.email }}</span>
                  </div>

                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">موضوع پیام یا نوع پروژه *</label>
                    <input 
                      v-model="form.subject"
                      type="text" 
                      required
                      placeholder="مثال: درخواست طراحی سایت فروشگاهی"
                      class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition"
                    />
                    <span v-if="form.errors.subject" class="text-xs text-red-500 mt-1 block">{{ form.errors.subject }}</span>
                  </div>
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-700 mb-2">شرح پیام یا جزئیات درخواست *</label>
                  <textarea 
                    v-model="form.message"
                    rows="5"
                    required
                    placeholder="توضیحات تکمیلی، نیازمندی‌ها، بودجه یا سوالات خود را بنویسید..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition resize-none"
                  ></textarea>
                  <span v-if="form.errors.message" class="text-xs text-red-500 mt-1 block">{{ form.errors.message }}</span>
                </div>

                <div>
                  <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="px-8 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 transition disabled:opacity-50 flex items-center gap-2"
                  >
                    <Send class="w-4 h-4" />
                    <span>{{ form.processing ? 'در حال ارسال...' : 'ارسال درخواست مشاوره' }}</span>
                  </button>
                </div>
              </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </PublicLayout>
</template>