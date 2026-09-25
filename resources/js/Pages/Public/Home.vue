<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ServiceCard from '@/Components/ServiceCard.vue';
import PortfolioCard from '@/Components/PortfolioCard.vue';
import { 
  Sparkles, 
  ArrowLeft, 
  CheckCircle2, 
  Star, 
  HelpCircle, 
  ChevronDown, 
  Calculator, 
  Clock
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
const heroPortfolio = computed(() => props.featuredPortfolios.find(portfolio => portfolio.image));

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
  seo: { name: 'سئو تکنیکال و بهینه‌سازی سرعت', price: 5, days: 3 },
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

const orderLink = computed(() => {
  const serviceTypes = {
    corporate: 'طراحی وب‌سایت شرکتی',
    shop: 'فروشگاه اینترنتی جامع',
    custom: 'سامانه و وب‌اپلیکیشن اختصاصی',
    redesign: 'بهینه‌سازی سئو و سرعت',
  };
  const budget = estimatedPrice.value < 20 ? 'زیر ۲۰ میلیون تومان'
    : estimatedPrice.value < 40 ? '۲۰ الی ۴۰ میلیون تومان'
      : estimatedPrice.value < 70 ? '۴۰ الی ۷۰ میلیون تومان' : 'بیش از ۷۰ میلیون تومان';
  const params = new URLSearchParams({
    service_type: serviceTypes[projectType.value],
    budget_range: budget,
    estimate: `${estimatedPrice.value} میلیون تومان / ${estimatedDays.value} روز کاری`,
    design_level: designLevel.value === 'premium' ? 'اختصاصی' : 'استاندارد',
    add_ons: addOns.value.map(key => addOnPrices[key].name).join('، '),
  });
  return `${route('orders.create')}?${params.toString()}`;
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
    a: 'نیازهای فنی سئو و عملکرد در مرحلهٔ بررسی مشخص می‌شوند. نتیجه به نوع محتوا، زیرساخت و شرایط پروژه وابسته است.',
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

</script>

<template>
  <Head title="سلمیر | آژانس طراحی وب و توسعه پلتفرم‌های دیجیتال" />
  
  <PublicLayout>
    <!-- 1. HERO -->
    <section class="bg-white py-16 lg:py-24">
      <div class="ui-container grid items-center gap-12 lg:grid-cols-12">
        <div :class="heroPortfolio ? 'lg:col-span-7' : 'lg:col-span-10'">
          <p class="mb-5 text-sm font-bold text-blue-700">آژانس مهندسی وب سلمیر</p>
          <h1 class="max-w-3xl text-[34px] font-black leading-[1.35] text-slate-900 sm:text-5xl lg:text-6xl lg:leading-[1.2]">
            طراحی و توسعهٔ وب برای کسب‌وکارهایی که به اجرای دقیق نیاز دارند
          </h1>
          <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
            از شناخت نیاز تا طراحی، توسعه و پشتیبانی، مسیر پروژه‌تان را با یک تیم و در پنل اختصاصی پیگیری کنید.
          </p>
          <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
            <Link :href="route('orders.create')" class="ui-button ui-button-primary px-7 py-3.5">ثبت درخواست پروژه <ArrowLeft class="h-4 w-4" aria-hidden="true" /></Link>
            <Link :href="route('portfolio.index')" class="ui-button ui-button-secondary px-7 py-3.5">دیدن نمونه‌کارها</Link>
          </div>
          <a href="#estimator" class="mt-5 inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
            برآورد اولیهٔ هزینه و زمان <ArrowLeft class="h-4 w-4" aria-hidden="true" />
          </a>
        </div>
        <div v-if="heroPortfolio" class="lg:col-span-5">
          <Link :href="route('portfolio.show', heroPortfolio.slug)" class="ui-card group block overflow-hidden">
            <img :src="heroPortfolio.image.startsWith('http') ? heroPortfolio.image : '/storage/' + heroPortfolio.image" :alt="'نمای پروژه ' + heroPortfolio.title" class="aspect-[4/3] w-full object-cover transition-transform duration-180 group-hover:scale-[1.02]" />
            <div class="p-5">
              <p class="text-xs font-semibold text-blue-700">نمونه‌کار منتخب</p>
              <p class="mt-2 text-lg font-bold text-slate-900">{{ heroPortfolio.title }}</p>
              <p v-if="heroPortfolio.client_name" class="mt-1 text-sm text-slate-600">{{ heroPortfolio.client_name }}</p>
            </div>
          </Link>
        </div>
      </div>
    </section>

    <!-- 2. VALUE AND CAPABILITIES -->
    <section class="border-y border-slate-200 bg-slate-50 py-12">
      <div class="ui-container">
        <h2 class="mb-6 text-2xl font-black text-slate-900">مسیر همکاری با سلمیر</h2>
        <div class="mb-6 flex flex-wrap gap-2" role="group" aria-label="حوزه‌های همکاری">
          <button v-for="tab in [
            { id: 'performance', title: 'طراحی و تجربهٔ کاربری' },
            { id: 'code', title: 'توسعهٔ فنی' },
            { id: 'support', title: 'پیگیری و پشتیبانی' },
          ]" :key="tab.id" type="button" @click="activeHeroTab = tab.id" :aria-pressed="activeHeroTab === tab.id"
            class="min-h-11 rounded-xl border px-4 py-2 text-sm font-bold transition-colors duration-150"
            :class="activeHeroTab === tab.id ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-blue-300'">
            {{ tab.title }}
          </button>
        </div>
        <div class="ui-card max-w-3xl p-6 text-sm leading-8 text-slate-700 sm:p-8">
          <p v-if="activeHeroTab === 'performance'">نیازهای کاربران و هویت برند در طراحی مسیرها و صفحه‌ها بررسی می‌شود؛ سپس طرح قابل بازبینی پیش از توسعه آماده می‌کنیم.</p>
          <p v-else-if="activeHeroTab === 'code'">پیاده‌سازی وب و پنل‌های اختصاصی با ساختار قابل نگهداری انجام می‌شود و مسیر تحویل هر مرحله روشن می‌ماند.</p>
          <p v-else>پس از ثبت سفارش، وضعیت پروژه و گفت‌وگوهای پشتیبانی را از پنل کاربری خود دنبال می‌کنید.</p>
        </div>
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
              <div class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">۱</span>
                <span>نوع پروژه شما چیست؟</span>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button 
                  v-for="(val, key) in projectTypePrices" 
                  :key="key"
                  type="button"
                  @click="projectType = key"
                  :aria-pressed="projectType === key"
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
              <div class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">۲</span>
                <span>سطح دیزاین و تجربه کاربری (UI/UX):</span>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button 
                  type="button"
                  @click="designLevel = 'standard'"
                  :aria-pressed="designLevel === 'standard'"
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
                  :aria-pressed="designLevel === 'premium'"
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
              <div class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">۳</span>
                <span>امکانات جانبی مورد نیاز:</span>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <button 
                  v-for="(val, key) in addOnPrices" 
                  :key="key"
                  type="button"
                  @click="toggleAddOn(key)"
                  :aria-pressed="addOns.includes(key)"
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
          <div class="bg-blue-800 text-white rounded-2xl p-6 sm:p-8 flex flex-col justify-between">
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
                :href="orderLink"
                class="ui-button w-full bg-white text-blue-800 hover:bg-blue-50"
              >
                ثبت سفارش با این مشخصات
              </Link>
              <div class="text-[11px] text-center text-blue-200/80">
                برآورد اولیه است و پس از بررسی نیازها نهایی می‌شود.
              </div>
            </div>

          </div>

        </div>

      </div>
    </section>

    <!-- 4. SERVICES SECTION -->
    <section class="ui-section bg-white">
      <div class="ui-container">
        <div class="mb-10 max-w-2xl">
          <span class="text-sm font-semibold text-blue-700">خدمات</span>
          <h2 class="mt-2 text-3xl font-bold text-ink">راهکارهایی متناسب با نیاز پروژه</h2>
          <p class="mt-3 text-copy">از طراحی و توسعه تا نگهداری، خدمات موجود را بررسی کنید.</p>
        </div>
        <div v-if="services.length" class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
          <ServiceCard v-for="service in services" :key="service.id" :service="service" />
        </div>
        <div v-else class="ui-empty">در حال حاضر خدمتی برای نمایش ثبت نشده است.</div>
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
            مسیر همکاری از بررسی نیازها تا طراحی، اجرا و تحویل.
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
    <section v-if="featuredPortfolios.length" class="ui-section bg-surface-soft">
      <div class="ui-container">
        <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
          <div>
            <span class="text-sm font-semibold text-blue-700">نمونه‌کارها</span>
            <h2 class="mt-2 text-3xl font-bold text-ink">پروژه‌های منتخب</h2>
          </div>
          <Link :href="route('portfolio.index')" class="ui-button ui-button-secondary">مشاهده همه پروژه‌ها <ArrowLeft class="h-4 w-4" aria-hidden="true" /></Link>
        </div>
        <div class="grid gap-5 lg:grid-cols-2">
          <PortfolioCard v-for="(portfolio, index) in featuredPortfolios" :key="portfolio.id" :portfolio="portfolio" :featured="index === 0" :class="index === 0 ? 'lg:col-span-2' : ''" />
        </div>
      </div>
    </section>

    <!-- 7. TESTIMONIALS -->
    <section v-if="testimonials.length" class="ui-section bg-white">
      <div class="ui-container">
        <div class="mb-10">
          <span class="text-sm font-semibold text-blue-700">تجربه همکاری</span>
          <h2 class="mt-2 text-3xl font-bold text-ink">نظر کارفرمایان</h2>
        </div>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
          <blockquote v-for="item in testimonials" :key="item.id" class="ui-card flex flex-col p-6">
            <div v-if="item.rating" class="mb-4 flex gap-1 text-amber-600" :aria-label="'امتیاز ' + item.rating + ' از ۵'">
              <Star v-for="star in item.rating" :key="star" class="h-4 w-4 fill-current" aria-hidden="true" />
            </div>
            <p class="flex-1 text-sm leading-7 text-copy">{{ item.content }}</p>
            <footer class="mt-6 border-t border-line pt-4">
              <div class="font-semibold text-ink">{{ item.name }}</div>
              <div v-if="item.company" class="mt-1 text-xs text-muted">{{ item.company }}</div>
            </footer>
          </blockquote>
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
              :aria-expanded="faq.isOpen"
              :aria-controls="'faq-answer-' + index"
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
              :id="'faq-answer-' + index"
              class="px-5 pb-5 pt-1 text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50"
            >
              {{ faq.a }}
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 9. FINAL CTA -->
    <section class="ui-section bg-blue-800 text-white">
      <div class="ui-container text-center">
        <h2 class="mx-auto max-w-3xl text-3xl font-bold leading-snug sm:text-4xl">برای پروژهٔ بعدی آماده‌اید؟</h2>
        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-blue-100 sm:text-base">نیاز خود را ثبت کنید تا دربارهٔ مسیر اجرا و جزئیات پروژه گفتگو کنیم.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
          <Link :href="route('orders.create')" class="ui-button bg-white text-blue-800 hover:bg-blue-50">ثبت درخواست پروژه</Link>
          <Link :href="route('contact.index')" class="ui-button border border-blue-400 text-white hover:bg-blue-700">تماس با ما</Link>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>
