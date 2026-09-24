<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  Sparkles, 
  ArrowLeft, 
  CheckCircle2, 
  Layers, 
  Laptop, 
  ShieldCheck, 
  Zap, 
  Smartphone, 
  Search, 
  Headphones, 
  Palette, 
  Code2, 
  Star, 
  HelpCircle, 
  ChevronDown, 
  Calculator, 
  Clock, 
  ExternalLink,
  Award,
  Users2,
  TrendingUp,
  FileCheck
} from 'lucide-vue-next';

const props = defineProps({
  services: {
    type: Array,
    default: () => []
  },
  featuredPortfolios: {
    type: Array,
    default: () => []
  },
  testimonials: {
    type: Array,
    default: () => []
  },
});

// Interactive Hero Preview Tabs
const activeHeroTab = ref('performance');

// Interactive Cost Estimator State
const projectType = ref('corporate'); // corporate, shop, custom, redesign
const designLevel = ref('premium'); // standard, premium
const addOns = ref(['seo', 'support']); // payment, ticket, multilanguage, seo, support

const projectTypePrices = {
  corporate: { name: 'وب‌سایت شرکتی و معرفی خدمات', basePrice: 18, days: 12 },
  shop: { name: 'فروشگاه اینترنتی جامع', basePrice: 32, days: 22 },
  custom: { name: 'پلتفرم و سامانه تحت وب اختصاصی', basePrice: 48, days: 35 },
  redesign: { name: 'بازطراحی و ارتقای سرعت سایت', basePrice: 15, days: 10 },
};

const addOnPrices = {
  payment: { name: 'اتصال به درگاه بانکی و صدور فاکتور', price: 4, days: 2 },
  ticket: { name: 'سیستم تیکتینگ و گفتگوی اختصاصی', price: 6, days: 4 },
  multilanguage: { name: 'پشتیبانی از چندزبانگی (انگلیسی/عربی)', price: 7, days: 5 },
  seo: { name: 'سئو تکنیکال و بهینه‌سازی سرعت ۱۰۰٪', price: 5, days: 3 },
  support: { name: 'پشتیبانی فنی ۶ ماهه اختصاصی VIP', price: 6, days: 0 },
};

const toggleAddOn = (key) => {
  if (addOns.value.includes(key)) {
    addOns.value = addOns.value.filter(k => k !== key);
  } else {
    addOns.value.push(key);
  }
};

const estimatedPrice = computed(() => {
  let total = projectTypePrices[projectType.value].basePrice;
  if (designLevel.value === 'premium') {
    total += 6;
  }
  addOns.value.forEach(key => {
    if (addOnPrices[key]) {
      total += addOnPrices[key].price;
    }
  });
  return total;
});

const estimatedDays = computed(() => {
  let days = projectTypePrices[projectType.value].days;
  if (designLevel.value === 'premium') {
    days += 4;
  }
  addOns.value.forEach(key => {
    if (addOnPrices[key]) {
      days += addOnPrices[key].days;
    }
  });
  return days;
});

// FAQ Accordion State
const faqs = ref([
  {
    q: 'مدت زمان طراحی و تحویل وب‌سایت معمولاً چقدر است؟',
    a: 'بسته به گستردگی پروژه، وب‌سایت‌های شرکتی بین ۱۰ الی ۲۰ روز کاری و سامانه‌ها یا فروشگاه‌های اختصاصی بین ۲۰ الی ۴۵ روز کاری طراحی، کدنویسی، تست و تحویل داده می‌شوند.',
    isOpen: true
  },
  {
    q: 'آیا سایت‌ها قابلیت ارتقا و شخصی‌سازی در آینده دارند؟',
    a: 'بله کاملاً! با توجه به معماری مدولار بر پایه Laravel و Vue 3، کدها کاملاً ماژولار بوده و بدون محدودیت قابلیت افزودن فیچرهای جدید، اتصال به API و اپلیکیشن در هر زمان را دارا هستند.',
    isOpen: false
  },
  {
    q: 'پشتیبانی فنی بعد از تحویل پروژه چگونه انجام می‌شود؟',
    a: 'تمامی پروژه‌ها دارای گارانتی رفع باگ و پشتیبانی رایگان هستند. علاوه بر این، می‌توانید از پنل تیکت اختصاصی سلمیر به‌صورت مستقیم با تیم فنی در ارتباط باشید.',
    isOpen: false
  },
  {
    q: 'آیا وب‌سایت طراحی شده در گوگل رتبه و سئوی مناسبی خواهد داشت؟',
    a: 'بله، تمامی استانداردها شامل سرعت بارگذاری زیر ۱ ثانیه، کدهای معنایی HTML5، متاتگ‌های داینامیک، نقشه سایت و بهینه‌سازی تصاویر به‌صورت پیش‌فرض رعایت می‌شوند.',
    isOpen: false
  },
  {
    q: 'فرآیند ثبت سفارش و پرداخت اقساطی به چه شکل است؟',
    a: 'پرداخت در ۳ یا ۴ مرحله متناسب با پیشرفت پروژه (پیش‌پرداخت اولیه، تایید طرح گرافیکی، تحویل نسخه اولیه و تسویه نهایی هنگام استقرار) انجام می‌پذیرد.',
    isOpen: false
  },
]);

const toggleFaq = (index) => {
  faqs.value[index].isOpen = !faqs.value[index].isOpen;
};

// Simulated mock icons for services
const getServiceIcon = (index) => {
  const icons = [Laptop, Palette, Search, Smartphone, Headphones, Code2];
  return icons[index % icons.length];
};
</script>

<template>
  <Head title="سلمیر | آژانس طراحی وب و توسعه پلتفرم‌های دیجیتال" />
  
  <PublicLayout>
    <!-- 1. HERO SECTION -->
    <section class="relative pt-12 pb-24 lg:pt-20 lg:pb-36 overflow-hidden bg-radial-glow bg-dot-pattern">
      <!-- Ambient light blobs -->
      <div class="absolute top-10 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none animate-pulse-slow"></div>
      <div class="absolute bottom-10 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        
        <!-- Live Alert Badge -->
        <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-blue-50/90 border border-blue-200/80 shadow-xs mb-8 text-xs sm:text-sm font-semibold text-blue-700 animate-float">
          <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
          </span>
          <span>آژانس تخصصی مهندسی وب، سیستم تیکتینگ و سفارش سفارشی</span>
          <ArrowLeft class="w-3.5 h-3.5" />
        </div>

        <!-- Main Headline -->
        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-slate-900 tracking-tight leading-[1.2] lg:leading-[1.15] mb-8 max-w-4xl mx-auto">
          طراحی وب‌سایت‌های
          <span class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 bg-clip-text text-transparent">
            فوق مدرن، سریع و ماندگار
          </span>
        </h1>

        <!-- Subtitle -->
        <p class="text-base sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed mb-10">
          ما با ترکیب معماری مدرن Laravel 12، چابکی Vue 3 و استانداردهای لوکس بصری، وب‌سایتی را برای شما خلق می‌کنیم که مشتریان شما را شگفت‌زده و کسب‌وکارتان را متحول می‌کند.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-4 mb-16">
          <Link 
            :href="route('orders.create')" 
            class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-base shadow-xl shadow-blue-500/25 hover:shadow-2xl hover:shadow-blue-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2.5"
          >
            <Sparkles class="w-5 h-5" />
            <span>ثبت سفارش اختصاصی</span>
            <ArrowLeft class="w-4 h-4" />
          </Link>

          <a 
            href="#estimator" 
            class="px-7 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 border border-slate-200/90 font-bold text-base shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 flex items-center gap-2"
          >
            <Calculator class="w-5 h-5 text-blue-600" />
            <span>محاسبه آنلاین هزینه</span>
          </a>

          <Link 
            href="/portfolio" 
            class="px-6 py-4 rounded-2xl text-slate-600 hover:text-blue-600 font-semibold text-base transition flex items-center gap-1.5"
          >
            <span>نمونه‌کارها</span>
            <ArrowLeft class="w-4 h-4" />
          </Link>
        </div>

        <!-- 3. HERO INTERACTIVE MOCKUP SHOWCASE -->
        <div class="max-w-5xl mx-auto relative">
          <!-- Floating badge left -->
          <div class="hidden md:flex absolute -top-6 -right-6 z-20 items-center gap-3 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-slate-100 animate-float">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
              <CheckCircle2 class="w-5 h-5" />
            </div>
            <div class="text-right">
              <div class="text-xs font-bold text-slate-900">۱۰۰٪ تحویل به‌موقع</div>
              <div class="text-[11px] text-slate-500">تضمین کیفیت با قرارداد رسمی</div>
            </div>
          </div>

          <!-- Floating badge right -->
          <div class="hidden md:flex absolute -bottom-6 -left-6 z-20 items-center gap-3 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-slate-100 animate-float-slow">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
              <Zap class="w-5 h-5" />
            </div>
            <div class="text-right">
              <div class="text-xs font-bold text-slate-900">سرعت فوق‌العاده ۹۹٪</div>
              <div class="text-[11px] text-slate-500">Core Web Vitals سبز</div>
            </div>
          </div>

          <!-- Browser Window Frame -->
          <div class="rounded-3xl border border-slate-200/80 bg-white/90 backdrop-blur-2xl shadow-2xl shadow-blue-500/10 overflow-hidden text-right">
            <!-- Window Bar -->
            <div class="bg-slate-100/90 px-5 py-3.5 border-b border-slate-200/80 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-400"></span>
                <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
              </div>
              <div class="flex items-center gap-2 bg-white px-4 py-1 rounded-lg border border-slate-200 text-xs font-mono text-slate-500">
                <ShieldCheck class="w-3.5 h-3.5 text-emerald-500" />
                <span>https://solmir.com/experience</span>
              </div>
              <div class="flex items-center gap-2 text-xs font-bold text-blue-600">
                <span>پیش‌نمایش تعاملی</span>
              </div>
            </div>

            <!-- Window Content -->
            <div class="p-6 md:p-10 bg-slate-50/50">
              <!-- Mockup Tabs -->
              <div class="flex items-center justify-center gap-2 mb-8 bg-slate-200/60 p-1.5 rounded-2xl max-w-md mx-auto">
                <button 
                  @click="activeHeroTab = 'performance'"
                  class="flex-1 py-2 px-3 rounded-xl text-xs sm:text-sm font-bold transition-all"
                  :class="activeHeroTab === 'performance' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                >
                  ⚡ عملکرد و سرعت
                </button>
                <button 
                  @click="activeHeroTab = 'code'"
                  class="flex-1 py-2 px-3 rounded-xl text-xs sm:text-sm font-bold transition-all"
                  :class="activeHeroTab === 'code' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                >
                  🛠️ معماری فنی
                </button>
                <button 
                  @click="activeHeroTab = 'support'"
                  class="flex-1 py-2 px-3 rounded-xl text-xs sm:text-sm font-bold transition-all"
                  :class="activeHeroTab === 'support' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                >
                  🎫 سیستم تیکتینگ
                </button>
              </div>

              <!-- Tab 1: Performance -->
              <div v-if="activeHeroTab === 'performance'" class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs hover:border-blue-200 transition">
                  <div class="text-4xl font-black text-emerald-500 mb-1">۹۹/۱۰۰</div>
                  <div class="text-sm font-bold text-slate-800">Google PageSpeed</div>
                  <p class="text-xs text-slate-500 mt-2">بارگذاری در کمتر از ۱ ثانیه بدون وقفه</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs hover:border-blue-200 transition">
                  <div class="text-4xl font-black text-blue-600 mb-1">۱۰۰٪</div>
                  <div class="text-sm font-bold text-slate-800">ریسپانسیو موبایل و دسکتاپ</div>
                  <p class="text-xs text-slate-500 mt-2">نمایش ایده‌آل در آیفون، اندروید و تبلت</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs hover:border-blue-200 transition">
                  <div class="text-4xl font-black text-indigo-600 mb-1">A+</div>
                  <div class="text-sm font-bold text-slate-800">امنیت و گواهی SSL</div>
                  <p class="text-xs text-slate-500 mt-2">محافظت در برابر حملات DDoS و نفوذ</p>
                </div>
              </div>

              <!-- Tab 2: Code Architecture -->
              <div v-if="activeHeroTab === 'code'" class="bg-slate-900 rounded-2xl p-6 text-left dir-ltr font-mono text-xs sm:text-sm text-slate-300 overflow-x-auto shadow-inner">
                <div class="text-slate-500 mb-2">// Modern Full-Stack Stack</div>
                <div class="text-pink-400">const <span class="text-yellow-300">solmirEngine</span> = {</div>
                <div class="pl-4 text-slate-300">backend: <span class="text-emerald-400">'Laravel 12 (PHP 8.4)'</span>,</div>
                <div class="pl-4 text-slate-300">frontend: <span class="text-emerald-400">'Vue 3 + Inertia.js (Composition API)'</span>,</div>
                <div class="pl-4 text-slate-300">styling: <span class="text-emerald-400">'Tailwind CSS 4 + RTL Native'</span>,</div>
                <div class="pl-4 text-slate-300">features: [<span class="text-emerald-400">'Online Custom Orders'</span>, <span class="text-emerald-400">'Live Chat Tickets'</span>, <span class="text-emerald-400">'Admin CMS'</span>]</div>
                <div class="text-pink-400">};</div>
              </div>

              <!-- Tab 3: Support -->
              <div v-if="activeHeroTab === 'support'" class="bg-white p-6 rounded-2xl border border-slate-100 text-right">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">پ</div>
                    <div>
                      <div class="text-sm font-bold text-slate-900">پشتیبانی فنی سلمیر</div>
                      <div class="text-xs text-emerald-600 font-medium">● آنلاین و پاسخگو</div>
                    </div>
                  </div>
                  <span class="text-xs text-slate-400">چند لحظه پیش</span>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                  سلام! تیکت شما توسط کارشناس ارشد ما بررسی شد و تغییرات درخواستی در سامانه اعمال گردید. هر زمان سوال یا درخواستی داشته باشید، در پنل پشتیبانی کنار شماییم.
                </p>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 2. TECH STACK CONTINUOUS MARQUEE -->
    <section class="py-8 bg-slate-900 border-y border-slate-800 overflow-hidden text-white">
      <div class="max-w-7xl mx-auto px-4 mb-3 text-center">
        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">توسعه‌یافته بر اساس استانداردهای روز جهان</span>
      </div>
      <div class="flex items-center gap-10 animate-marquee select-none whitespace-nowrap">
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">⚡ Laravel 12</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">💚 Vue.js 3</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">🟣 Inertia.js</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">🎨 Tailwind CSS 4</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">🟦 TypeScript</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">🚀 Vite 6</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">🔒 RESTful APIs & Security</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">🐳 Docker & Cloud</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">🎯 UI/UX Figma Design</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">⚡ Laravel 12</span>
        <span class="inline-flex items-center gap-2 text-sm font-mono text-slate-300 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700">💚 Vue.js 3</span>
      </div>
    </section>

    <!-- 3. INTERACTIVE PROJECT COST ESTIMATOR -->
    <section id="estimator" class="py-20 bg-slate-50 relative">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-14">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-100/80 text-blue-700 font-bold text-xs mb-3">
            <Calculator class="w-4 h-4" />
            <span>ابزار برآورد هوشمند</span>
          </div>
          <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-4">
            محاسبه آنلاین هزینه و زمان تحویل پروژه
          </h2>
          <p class="text-slate-600 max-w-xl mx-auto text-sm sm:text-base">
            مشخصات مدنظر خود را مشخص کنید تا در لحظه برآورد هزینه و مدت‌زمان تحویل پروژه را مشاهده نمایید.
          </p>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/80 grid grid-cols-1 lg:grid-cols-3 gap-10">
          
          <!-- Controls (2 cols) -->
          <div class="lg:col-span-2 space-y-8">
            <!-- Step 1: Type -->
            <div>
              <label class="block text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">۱</span>
                <span>نوع پروژه شما چیست؟</span>
              </label>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button 
                  v-for="(val, key) in projectTypePrices" 
                  :key="key"
                  type="button"
                  @click="projectType = key"
                  class="p-4 rounded-2xl border text-right transition-all flex flex-col justify-between"
                  :class="projectType === key 
                    ? 'border-blue-600 bg-blue-50/70 text-blue-900 ring-2 ring-blue-500/20 shadow-xs' 
                    : 'border-slate-200 hover:border-slate-300 text-slate-700 hover:bg-slate-50'"
                >
                  <span class="font-bold text-sm mb-1">{{ val.name }}</span>
                  <span class="text-xs text-slate-500">پایه از {{ val.basePrice }} میلیون</span>
                </button>
              </div>
            </div>

            <!-- Step 2: Design Level -->
            <div>
              <label class="block text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">۲</span>
                <span>سطح دیزاین و تجربه کاربری (UI/UX):</span>
              </label>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button 
                  type="button"
                  @click="designLevel = 'standard'"
                  class="p-4 rounded-2xl border text-right transition-all"
                  :class="designLevel === 'standard' 
                    ? 'border-blue-600 bg-blue-50/70 text-blue-900 ring-2 ring-blue-500/20' 
                    : 'border-slate-200 hover:border-slate-300 text-slate-700 hover:bg-slate-50'"
                >
                  <div class="font-bold text-sm">استاندارد و مینیمال</div>
                  <div class="text-xs text-slate-500 mt-1">طراحی تمیز، مدرن و فوکوس بر سرعت</div>
                </button>
                <button 
                  type="button"
                  @click="designLevel = 'premium'"
                  class="p-4 rounded-2xl border text-right transition-all"
                  :class="designLevel === 'premium' 
                    ? 'border-blue-600 bg-blue-50/70 text-blue-900 ring-2 ring-blue-500/20' 
                    : 'border-slate-200 hover:border-slate-300 text-slate-700 hover:bg-slate-50'"
                >
                  <div class="font-bold text-sm flex items-center gap-1.5 text-blue-700">
                    <Sparkles class="w-4 h-4 text-blue-600" />
                    لوکس و اختصاصی (پیشنهادی)
                  </div>
                  <div class="text-xs text-slate-500 mt-1">انیمیشن‌های تعاملی، میکرو-اینتراکشن و جلوه‌های سه‌بعدی</div>
                </button>
              </div>
            </div>

            <!-- Step 3: Add-ons -->
            <div>
              <label class="block text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">۳</span>
                <span>امکانات جانبی مورد نیاز:</span>
              </label>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <button 
                  v-for="(val, key) in addOnPrices" 
                  :key="key"
                  type="button"
                  @click="toggleAddOn(key)"
                  class="p-3.5 rounded-xl border text-right transition-all flex items-center justify-between"
                  :class="addOns.includes(key) 
                    ? 'border-blue-500 bg-blue-50/60 text-blue-900' 
                    : 'border-slate-200 text-slate-700 hover:bg-slate-50'"
                >
                  <div class="flex items-center gap-2">
                    <div 
                      class="w-4 h-4 rounded-md border flex items-center justify-center text-white"
                      :class="addOns.includes(key) ? 'bg-blue-600 border-blue-600' : 'border-slate-300'"
                    >
                      <CheckCircle2 v-if="addOns.includes(key)" class="w-3.5 h-3.5" />
                    </div>
                    <span class="text-xs font-semibold">{{ val.name }}</span>
                  </div>
                  <span class="text-xs font-mono text-slate-500">+{{ val.price }}م</span>
                </button>
              </div>
            </div>

          </div>

          <!-- Result Card (1 col) -->
          <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 text-white rounded-2xl p-6 sm:p-8 flex flex-col justify-between shadow-lg shadow-blue-500/30">
            <div>
              <div class="text-xs font-bold uppercase tracking-wider text-blue-200 mb-1">خلاصه برآورد فنی</div>
              <h3 class="text-xl font-bold mb-6">پکیج سفارشی شما</h3>

              <div class="space-y-4 py-4 border-y border-white/20 text-sm">
                <div class="flex justify-between items-center">
                  <span class="text-blue-100">نوع پروژه:</span>
                  <span class="font-bold">{{ projectTypePrices[projectType].name }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-blue-100">سطح طراحی:</span>
                  <span class="font-bold">{{ designLevel === 'premium' ? 'اختصاصی و لوکس' : 'استاندارد' }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-blue-100">امکانات انتخابی:</span>
                  <span class="font-bold">{{ addOns.length }} مورد فعال</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                  <span class="text-blue-100 flex items-center gap-1.5">
                    <Clock class="w-4 h-4" />
                    زمان تحویل:
                  </span>
                  <span class="font-bold text-amber-300">{{ estimatedDays }} روز کاری</span>
                </div>
              </div>

              <div class="mt-6 text-center">
                <div class="text-xs text-blue-200">برآورد هزینه حدودی:</div>
                <div class="text-4xl font-black text-white mt-1">
                  {{ estimatedPrice }}
                  <span class="text-sm font-normal text-blue-200">میلیون تومان</span>
                </div>
              </div>
            </div>

            <div class="mt-8 space-y-2">
              <Link 
                :href="route('orders.create')" 
                class="w-full block py-3.5 px-4 rounded-xl bg-white text-blue-700 font-black text-center shadow-lg hover:bg-blue-50 hover:shadow-xl transition-all"
              >
                ثبت سفارش با این مشخصات
              </Link>
              <div class="text-[11px] text-center text-blue-200/80">
                مشاوره و بررسی فنی رایگان پیش از قرارداد
              </div>
            </div>

          </div>

        </div>

      </div>
    </section>

    <!-- 4. SERVICES SECTION -->
    <section class="py-24 bg-white relative">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
          <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold mb-3">
            <Layers class="w-4 h-4" />
            <span>خدمات آژانس سلمیر</span>
          </div>
          <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-4">
            راهکارهای مهندسی وب برای شتاب‌بخشی به رشد شما
          </h2>
          <p class="text-slate-600 max-w-xl mx-auto text-base">
            از طراحی صفر تا صد وب‌سایت‌های پیچیده تا نگهداری و ارتقای مداوم سامانه‌های نرم‌افزاری
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="(service, idx) in services" 
            :key="service.id" 
            class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between relative group"
          >
            <div>
              <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center mb-6 shadow-md shadow-blue-500/20 group-hover:scale-110 group-hover:shadow-blue-500/40 transition-all duration-300">
                <component :is="getServiceIcon(idx)" class="w-7 h-7" />
              </div>
              <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                {{ service.title }}
              </h3>
              <p class="text-slate-600 text-sm leading-relaxed mb-6">
                {{ service.description }}
              </p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
              <Link 
                :href="route('services.show', service.slug)" 
                class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5"
              >
                <span>مشاهده مشخصات و تعرفه</span>
                <ArrowLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
              </Link>
              <span class="text-xs text-slate-400 font-mono">#0{{ idx + 1 }}</span>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 5. WORKFLOW & PROCESS -->
    <section class="py-20 bg-slate-900 text-white relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center mb-16">
          <span class="text-blue-400 font-bold text-xs uppercase tracking-wider">فرآیند شفاف و مهندسی‌شده</span>
          <h2 class="text-3xl sm:text-4xl font-black mt-2 mb-4">
            پروژه شما چگونه در سلمیر خلق می‌شود؟
          </h2>
          <p class="text-slate-400 max-w-lg mx-auto text-sm sm:text-base">
            چهار گام برنامه‌ریزی‌شده برای اطمینان از تحویل سر وقت، بدون باگ و با بالاترین رضایت.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          
          <div class="bg-slate-800/60 border border-slate-700/70 p-6 rounded-2xl relative hover:border-blue-500 transition-all">
            <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 font-mono font-bold flex items-center justify-center mb-4">
              ۰۱
            </div>
            <h3 class="text-lg font-bold mb-2">نیازسنجی و استراتژی</h3>
            <p class="text-slate-400 text-xs leading-relaxed">
              تحلیل عمیق هدف بیزینس شما، بررسی رقبا، مخاطبان هدف و انتخاب بهترین معماری فنی.
            </p>
          </div>

          <div class="bg-slate-800/60 border border-slate-700/70 p-6 rounded-2xl relative hover:border-blue-500 transition-all">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-400 font-mono font-bold flex items-center justify-center mb-4">
              ۰۲
            </div>
            <h3 class="text-lg font-bold mb-2">طراحی بصری UI/UX</h3>
            <p class="text-slate-400 text-xs leading-relaxed">
              طراحی اختصاصی پروتوتایپ در فیگما با هویت برند، انیمیشن‌ها و جریان کاربرپسند.
            </p>
          </div>

          <div class="bg-slate-800/60 border border-slate-700/70 p-6 rounded-2xl relative hover:border-blue-500 transition-all">
            <div class="w-10 h-10 rounded-xl bg-sky-500/20 text-sky-400 font-mono font-bold flex items-center justify-center mb-4">
              ۰۳
            </div>
            <h3 class="text-lg font-bold mb-2">برنامه‌نویسی چابک</h3>
            <p class="text-slate-400 text-xs leading-relaxed">
              پیاده‌سازی دقیق فرانت و بک‌اند با Laravel و Vue 3 با بالاترین استانداردهای امنیتی و سرعت.
            </p>
          </div>

          <div class="bg-slate-800/60 border border-slate-700/70 p-6 rounded-2xl relative hover:border-blue-500 transition-all">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 font-mono font-bold flex items-center justify-center mb-4">
              ۰۴
            </div>
            <h3 class="text-lg font-bold mb-2">تست، تحویل و پشتیبانی</h3>
            <p class="text-slate-400 text-xs leading-relaxed">
              دیپلوی روی سرور ابری، آموزش کامل مدیریت پنل و همراهی دائم از طریق سیستم تیکتینگ.
            </p>
          </div>

        </div>

      </div>
    </section>

    <!-- 6. FEATURED PORTFOLIO -->
    <section class="py-24 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-4">
          <div>
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-blue-100/70 text-blue-700 text-xs font-bold mb-2">
              <Award class="w-4 h-4" />
              <span>پروژه‌های شاخص</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900">
              نمونه کارهای منتخب تیم سلمیر
            </h2>
          </div>
          <Link 
            href="/portfolio" 
            class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700 transition"
          >
            <span>مشاهده همه پروژه‌ها</span>
            <ArrowLeft class="w-4 h-4" />
          </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="portfolio in featuredPortfolios" 
            :key="portfolio.id"
            class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 hover:shadow-2xl hover:border-blue-200 transition-all duration-300 flex flex-col"
          >
            <!-- Simulated Mockup Graphic for Portfolio -->
            <div class="h-52 bg-gradient-to-tr from-slate-900 via-blue-950 to-indigo-900 relative overflow-hidden p-4 flex flex-col justify-between">
              <div class="flex items-center justify-between text-xs text-white/70">
                <span class="px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md font-mono text-[11px]">{{ portfolio.category }}</span>
                <ExternalLink class="w-4 h-4 text-white/50 group-hover:text-white transition" />
              </div>
              
              <!-- Mock UI Element -->
              <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/10 shadow-lg transform group-hover:-translate-y-1 transition duration-300">
                <div class="flex items-center gap-2 mb-2">
                  <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                  <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                  <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                  <div class="h-2 w-24 bg-white/20 rounded-full mr-2"></div>
                </div>
                <div class="h-10 bg-white/5 rounded-lg flex items-center justify-center text-xs font-mono text-blue-200">
                  {{ portfolio.title }}
                </div>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6 flex-grow flex flex-col justify-between">
              <div>
                <div class="text-xs text-blue-600 font-bold mb-2">کارفرما: {{ portfolio.client_name || 'اختصاصی' }}</div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition">
                  {{ portfolio.title }}
                </h3>
                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">
                  {{ portfolio.description }}
                </p>
              </div>

              <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <Link 
                  :href="route('portfolio.show', portfolio.slug)"
                  class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1"
                >
                  مشاهده جزییات و کیس‌استادی
                  <ArrowLeft class="w-3.5 h-3.5" />
                </Link>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section>

    <!-- 7. TESTIMONIALS -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold mb-3">
            <Star class="w-4 h-4 fill-amber-400 text-amber-400" />
            <span>نظرات کارفرمایان</span>
          </div>
          <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-4">
            روایت مشتریان از همراهی با آژانس سلمیر
          </h2>
          <p class="text-slate-600 max-w-md mx-auto text-sm">
            بزرگ‌ترین افتخار ما، موفقیت و رشد بیزینس‌های مشتریان عزیزمان است.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="item in testimonials" 
            :key="item.id"
            class="bg-slate-50 rounded-3xl p-8 border border-slate-200/70 shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between"
          >
            <div>
              <div class="flex items-center gap-1 mb-4 text-amber-400">
                <Star v-for="s in (item.rating || 5)" :key="s" class="w-4 h-4 fill-amber-400 text-amber-400" />
              </div>
              <p class="text-slate-700 text-sm leading-relaxed mb-6 italic">
                "{{ item.content }}"
              </p>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-200/60">
              <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                {{ item.name.charAt(0) }}
              </div>
              <div>
                <div class="text-sm font-bold text-slate-900">{{ item.name }}</div>
                <div class="text-xs text-slate-500">{{ item.company || 'مدیر پروژه' }}</div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 8. INTERACTIVE FAQ ACCORDION -->
    <section class="py-20 bg-slate-50 border-t border-slate-200">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-14">
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold mb-3">
            <HelpCircle class="w-4 h-4" />
            <span>پاسخ به ابهامات</span>
          </div>
          <h2 class="text-3xl font-black text-slate-900 mb-3">سوالات متداول کارفرمایان</h2>
          <p class="text-slate-600 text-sm">پاسخ به سوالاتی که معمولاً قبل از شروع همکاری مطرح می‌شوند</p>
        </div>

        <div class="space-y-4">
          <div 
            v-for="(faq, index) in faqs" 
            :key="index"
            class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden transition-all shadow-xs"
          >
            <button 
              @click="toggleFaq(index)" 
              type="button"
              class="w-full p-5 text-right font-bold text-slate-900 flex items-center justify-between hover:text-blue-600 transition"
            >
              <span class="text-base">{{ faq.q }}</span>
              <ChevronDown 
                class="w-5 h-5 text-slate-400 transition-transform duration-200 shrink-0" 
                :class="{ 'rotate-180 text-blue-600': faq.isOpen }" 
              />
            </button>
            <div 
              v-show="faq.isOpen" 
              class="px-5 pb-5 pt-1 text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50"
            >
              {{ faq.a }}
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 9. FINAL GRAND CTA -->
    <section class="py-20 bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-800 text-white relative overflow-hidden">
      <!-- Glow circles -->
      <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

      <div class="max-w-5xl mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl sm:text-5xl font-black mb-6 leading-tight">
          ایده وب‌سایت بعدی‌تان را به یک واقعیت متمایز تبدیل کنید
        </h2>
        <p class="text-blue-100 text-base sm:text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
          تیم مهندسی سلمیر آماده است تا با مشاوره تخصصی رایگان، مسیر پیاده‌سازی دیجیتال برند شما را شفاف کند.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
          <Link 
            :href="route('orders.create')" 
            class="px-9 py-4 rounded-2xl bg-white text-blue-700 hover:bg-blue-50 font-black text-base shadow-xl shadow-blue-900/30 hover:scale-105 transition-all duration-200 flex items-center gap-2"
          >
            <Sparkles class="w-5 h-5 text-blue-600" />
            <span>ثبت آنلاین سفارش جدید</span>
          </Link>

          <Link 
            href="/contact" 
            class="px-8 py-4 rounded-2xl bg-blue-800/80 hover:bg-blue-800 border border-blue-400/40 text-white font-bold text-base transition-all flex items-center gap-2"
          >
            <span>ارتباط با کارشناسان</span>
            <ArrowLeft class="w-4 h-4" />
          </Link>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>