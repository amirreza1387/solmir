<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';
import ServiceCard from '@/Components/ServiceCard.vue';
import PortfolioCard from '@/Components/PortfolioCard.vue';
import {
  Sparkles,
  ArrowLeft,
  ArrowRight,
  CheckCircle2,
  Star,
  HelpCircle,
  ChevronDown,
  ChevronLeft,
  ChevronRight,
  Calculator,
  Layout,
  Code2,
  ShieldCheck,
  Palette,
  Laptop,
  Terminal,
  Activity,
  Check,
  Monitor,
  Tablet,
  Smartphone,
  ExternalLink,
  Workflow,
  Play,
  Pause,
  Cpu,
  FileText,
  Zap,
  Server,
  Gauge,
  CheckCircle,
  RefreshCw
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

// Interactive Collaboration Journey State
const activeJourneyStep = ref(0);
const isAutoPlaying = ref(false);
let autoPlayTimer = null;

const journeySteps = [
  {
    id: 'discovery',
    phaseCode: 'PHASE_01 // SCOPE_DISCOVERY',
    stepNumber: '۰۱',
    title: 'شناخت بیزینس و نقشه راه معماری',
    shortTitle: 'تحلیل و معماری',
    badge: 'شروع دقیق',
    description: 'در نخستین گام، به جای کدنویسی شتاب‌زده، اهداف تجاری، رفتار کاربران و زیرساخت مورد نیاز کسب‌وکار شما را کالبدشکافی می‌کنیم تا نقشه راهی شفاف، مدون و بدون غافلگیری ترسیم شود.',
    deliverables: [
      'سند مدون مشخصات فنی و کارکردی پروژه (SRS)',
      'معماری اطلاعات و وایرفریم ساختار صفحات (IA)',
      'تعیین پشته فناوری متناسب و ساختار دیتابیس بهینه'
    ],
    highlightQuote: 'یک ساعت معماری و برنامه‌ریزی دقیق، مانع صد ساعت دوباره‌کاری و هزینه بیهوده در آینده می‌شود.',
    icon: FileText
  },
  {
    id: 'uiux',
    phaseCode: 'PHASE_02 // SYSTEM_UIUX',
    stepNumber: '۰۲',
    title: 'دیزاین سیستم و پروتوتایپ تعاملی در فیگما',
    shortTitle: 'طراحی UI/UX',
    badge: 'پروتوتایپ تعاملی',
    description: 'خلق هویت بصری ماندگار با استانداردهای روز جهانی. ما دیزاین سیستم کامپوننت‌محور را در Figma پیاده‌سازی می‌کنیم تا پیش از نوشتن هر خط کد، پروتوتایپ کلیک‌خور و زنده سایت‌تان را لمس کنید.',
    deliverables: [
      'دیزاین سیستم ماژولار و توکن‌های اختصاصی رنگ، تایپوگرافی و آیکون‌ها',
      'پروتوتایپ کلیک‌خور با تمام جریان‌های کاربری (User Flows)',
      'طراحی ریسپانسیو اختصاصی برای دسکتاپ، تبلت و گوشی‌های مختلف'
    ],
    highlightQuote: 'قبل از شروع کدنویسی، طرح نهایی را در گوشی و مانیتور خود بررسی کرده و تایید می‌نمایید.',
    icon: Palette
  },
  {
    id: 'engineering',
    phaseCode: 'PHASE_03 // AGILE_ENGINEERING',
    stepNumber: '۰۳',
    title: 'توسعه چابک، تمیز و ماژولار (فرانت و بک‌اند)',
    shortTitle: 'کدنویسی و توسعه',
    badge: 'استاندارد مهندسی',
    description: 'تبدیل پروتوتایپ به محصولی زنده، برق‌آسا و نفوذناپذیر. توسعه فرانت‌اند با Vue 3 مدرن و بک‌اند با Laravel 12 با تفکیک استاندارد لایه‌ها، رعایت کامل اصول Clean Code و ثبت لحظه‌ای تغییرات در Git.',
    deliverables: [
      'کدنویسی ماژولار و کامپوننت‌محور با لود بهینه در تمام دیوایس‌ها',
      'بک‌اند مقاوم با معماری تست‌پذیر و API استاندارد RESTful',
      'کنترل نسخه در Git با پوشش تست‌های خودکار یکپارچگی (PHPUnit)'
    ],
    highlightQuote: 'معماری مدرن و کدهای تمیز، مقیاس‌پذیری و رشد نامحدود کسب‌وکار شما را تضمین می‌کنند.',
    icon: Code2
  },
  {
    id: 'qa_audit',
    phaseCode: 'PHASE_04 // QUALITY_AUDIT',
    stepNumber: '۰۴',
    title: 'کنترل کیفیت عمیق و ممیزی سرعت گوگل',
    shortTitle: 'تست و ممیزی سرعت',
    badge: 'Core Web Vitals A+',
    description: 'پیش از عمومی‌سازی، سیستم زیر بار تست‌های چندگانه قرار می‌گیرد: ممیزی سرعت در Google PageSpeed با رتبه بالای ۹۰، اعتبارسنجی در ۷ اندازه مختلف نمایشگر و تست‌های امنیتی لایه‌ها.',
    deliverables: [
      'گزارش ممیزی گوگل با نمره سبز در سرعت، دسترس‌پذیری و سئو تکنیکال',
      'تست ریسپانسیو و عدم شکستگی تصویر یا اسکرول افقی روی دیوایس‌های واقعی',
      'مقاوم‌سازی امنیتی در برابر حملات متداول وب (OWASP Standards)'
    ],
    highlightQuote: 'هیچ پروژه‌ای بدون گذراندن موفقیت‌آمیز چک‌لیست سخت‌گیرانه کیفی سلمیر تحویل نمی‌شود.',
    icon: Gauge
  },
  {
    id: 'launch_support',
    phaseCode: 'PHASE_05 // CLIENT_LAUNCH',
    stepNumber: '۰۵',
    title: 'استقرار ابری، تحویل پنل و گارانتی اختصاصی',
    shortTitle: 'استقرار و پشتیبانی',
    badge: 'تضمین پایداری',
    description: 'استقرار روی سرورهای ابری با آپ‌تایم ۹۹.۹۸٪ و تحویل پنل کاربری سلمیر به شما. از این لحظه، تمام تیکت‌های فنی، گزارش‌های پشتیبانی و ارتقاهای سیستم مستقیماً در پنل پیگیری می‌شوند.',
    deliverables: [
      'کانفیگ سرور، بهینه‌سازی دیتابیس و نصب گواهی امنیتی SSL',
      'تحویل پنل مشتریان با امکان تیکت مستقیم به مهندسان پروژه',
      'گارانتی رفع باگ، مستندات آموزشی و همراهی مداوم در رشد سایت'
    ],
    highlightQuote: 'تحویل سایت آغاز یک شراکت بلندمدت است؛ تیم فنی سلمیر همیشه همراه شماست.',
    icon: ShieldCheck
  }
];

// 15-Second Automatic Progression & Interactive State
const timerKey = ref(0);
let autoAdvanceTimer = null;
const AUTO_ADVANCE_DELAY = 15000; // 15 seconds per stage

const startAutoAdvance = () => {
  stopAutoAdvance();
  autoAdvanceTimer = setInterval(() => {
    nextJourneyStep(false);
  }, AUTO_ADVANCE_DELAY);
};

const stopAutoAdvance = () => {
  if (autoAdvanceTimer) {
    clearInterval(autoAdvanceTimer);
    autoAdvanceTimer = null;
  }
};

const resetAutoAdvance = () => {
  startAutoAdvance();
  timerKey.value++;
};

const nextJourneyStep = (isManual = true) => {
  activeJourneyStep.value = (activeJourneyStep.value + 1) % journeySteps.length;
  if (isManual) {
    resetAutoAdvance();
  } else {
    timerKey.value++;
  }
};

const prevJourneyStep = () => {
  activeJourneyStep.value = (activeJourneyStep.value - 1 + journeySteps.length) % journeySteps.length;
  resetAutoAdvance();
};

const setJourneyStep = (index) => {
  activeJourneyStep.value = index;
  resetAutoAdvance();
};

// Mobile Touch Swipe Handling
let touchStartX = 0;
let touchEndX = 0;

const handleTouchStart = (e) => {
  if (e.changedTouches && e.changedTouches[0]) {
    touchStartX = e.changedTouches[0].screenX;
  }
};

const handleTouchEnd = (e) => {
  if (e.changedTouches && e.changedTouches[0]) {
    touchEndX = e.changedTouches[0].screenX;
    const diff = touchEndX - touchStartX;
    if (Math.abs(diff) > 40) {
      if (diff < 0) {
        nextJourneyStep(true);
      } else {
        prevJourneyStep();
      }
    }
  }
};

const journeyProgressPercent = computed(() => {
  return Math.round(((activeJourneyStep.value + 1) / journeySteps.length) * 100);
});

onMounted(() => {
  startAutoAdvance();
});

onUnmounted(() => {
  stopAutoAdvance();
});

const heroPortfolio = computed(() => props.featuredPortfolios.find(portfolio => portfolio.image));

// Interactive Cost Estimator State
const projectType = ref('corporate'); // corporate, shop, custom, redesign
const designLevel = ref('premium'); // standard, premium
const addOns = ref(['seo', 'support']); // payment, ticket, multilanguage, seo, support

const projectTypePrices = {
  corporate: { name: 'وب‌سایت شرکتی و معرفی خدمات', basePrice: 18 },
  shop: { name: 'فروشگاه اینترنتی جامع', basePrice: 32 },
  custom: { name: 'پلتفرم و سامانه تحت وب اختصاصی', basePrice: 48 },
  redesign: { name: 'بازطراحی و ارتقای سرعت سایت', basePrice: 15 },
};

const addOnPrices = {
  payment: { name: 'اتصال به درگاه بانکی و صدور فاکتور', price: 4 },
  ticket: { name: 'سیستم تیکتینگ و گفتگوی اختصاصی', price: 6 },
  multilanguage: { name: 'پشتیبانی از چندزبانگی (انگلیسی/عربی)', price: 7 },
  seo: { name: 'سئو تکنیکال و بهینه‌سازی سرعت', price: 5 },
  support: { name: 'پشتیبانی فنی ۶ ماهه اختصاصی VIP', price: 6 },
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
    estimate: `${estimatedPrice.value} میلیون تومان`,
    design_level: designLevel.value === 'premium' ? 'اختصاصی' : 'استاندارد',
    add_ons: addOns.value.map(key => addOnPrices[key].name).join('، '),
  });
  return `${route('orders.create')}?${params.toString()}`;
});

// FAQ Accordion State
const faqs = ref([
  {
    q: 'زمان‌بندی و فازهای اجرای پروژه چگونه تعیین می‌شود؟',
    a: 'پس از جلسه مشاوره و تدوین سند مشخصات فنی (SRS)، با توجه به اسکوپ دقیق نیازمندی‌ها و امکانات مدنظر شما، یک برنامه‌ریزی زمان‌بندی شفاف، مایلستون‌بندی‌شده و اختصاصی ارائه می‌گردد.',
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

const homeSchema = {
  '@context': 'https://schema.org',
  '@graph': [
    {
      '@type': 'WebSite',
      '@id': 'https://solmir.ir/#website',
      'url': 'https://solmir.ir',
      'name': 'Solmir',
      'description': 'آژانس طراحی وب و توسعه پلتفرم‌های دیجیتال',
      'inLanguage': 'fa-IR',
    },
    {
      '@type': 'Organization',
      '@id': 'https://solmir.ir/#organization',
      'name': 'Solmir',
      'url': 'https://solmir.ir',
      'logo': 'https://solmir.ir/favicon-32x32.png',
      'email': 'solmirofc@gmail.com',
      'telephone': '+989179278747',
      'description': 'آژانس مهندسی وب و طراحی دیجیتال سلمیر؛ ارائه راهکارهای نوین توسعه وب، طراحی UI/UX و سیستم‌های نرم‌افزاری اختصاصی.',
    },
  ],
};

</script>

<template>
  <SeoHead
    title="سلمیر | آژانس طراحی وب و توسعه پلتفرم‌های دیجیتال"
    description="آژانس مهندسی وب و طراحی دیجیتال سلمیر؛ طراحی اختصاصی وب‌سایت‌های شرکتی و فروشگاهی، رابط کاربری لوکس UI/UX و سیستم‌های نرم‌افزاری مقیاس‌پذیر با Laravel و Vue 3."
    :schema="homeSchema"
  />

  <PublicLayout>
    <!-- 1. HERO SECTION -->
    <section class="relative overflow-hidden bg-white py-16 lg:py-24">
      <!-- Subtle Technical Grid Background -->
      <div class="pointer-events-none absolute inset-0 bg-tech-lines opacity-40 [mask-image:radial-gradient(ellipse_at_center,black_40%,transparent_85%)]"></div>

      <!-- Subtle Technical Corner Crosshairs (Desktop) -->
      <div class="pointer-events-none absolute top-4 left-6 hidden select-none font-mono text-[10px] text-slate-400/80 lg:block">+ 35.6892° N / 51.3890° E // SOLMIR_STUDIO_V2</div>
      <div class="pointer-events-none absolute top-4 right-6 hidden select-none font-mono text-[10px] text-slate-400/80 lg:block">SYS_STATUS: OPTIMAL [100%] +</div>

      <div class="ui-container relative z-10 grid items-center gap-12 lg:grid-cols-12">
        <!-- Left: Hero Content -->
        <div class="lg:col-span-6 xl:col-span-6">
          <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-blue-200/70 bg-blue-50/80 px-3.5 py-1 text-xs font-bold text-blue-700 shadow-2xs">
            <span class="relative flex h-2 w-2">
              <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
            </span>
            <span>آژانس مهندسی وب و طراحی دیجیتال سلمیر</span>
          </div>

          <h1 class="max-w-2xl text-[34px] font-black leading-[1.3] text-slate-900 sm:text-5xl lg:text-[54px] lg:leading-[1.18]">
            طراحی و توسعهٔ وب برای کسب‌وکارهایی که به اجرای دقیق نیاز دارند
          </h1>

          <p class="mt-6 max-w-xl text-base leading-8 text-slate-600 sm:text-lg">
            از شناخت نیاز تا طراحی، توسعه و پشتیبانی، مسیر پروژه‌تان را با یک تیم و در پنل اختصاصی پیگیری کنید.
          </p>

          <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
            <Link :href="route('orders.create')" class="ui-button ui-button-primary px-7 py-3.5 shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/30">
              ثبت درخواست پروژه <ArrowLeft class="h-4 w-4" aria-hidden="true" />
            </Link>
            <Link :href="route('portfolio.index')" class="ui-button ui-button-secondary px-7 py-3.5">
              دیدن نمونه‌کارها
            </Link>
          </div>

          <div class="mt-5 flex items-center gap-4">
            <a href="#estimator" class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
              برآورد هوشمند بودجه پروژه <ArrowLeft class="h-4 w-4" aria-hidden="true" />
            </a>
          </div>

          <!-- Micro Technical Specs Row -->
          <div class="mt-8 flex flex-wrap items-center gap-2.5 border-t border-slate-100 pt-6 text-xs text-slate-500">
            <span class="font-mono text-[11px] font-semibold text-slate-400">STACK:</span>
            <span class="inline-flex items-center gap-1 rounded-md border border-slate-200 bg-slate-50 px-2 py-0.5 font-medium text-slate-700">Vue 3 & TS</span>
            <span class="inline-flex items-center gap-1 rounded-md border border-slate-200 bg-slate-50 px-2 py-0.5 font-medium text-slate-700">Laravel 12 Architecture</span>
            <span class="inline-flex items-center gap-1 rounded-md border border-slate-200 bg-slate-50 px-2 py-0.5 font-medium text-slate-700">Core Web Vitals A+</span>
          </div>
        </div>

        <!-- Right: Browser & Digital Interface Composition -->
        <div class="relative lg:col-span-6 xl:col-span-6">
          <!-- Floating Badge 1 (Top Left in RTL) -->
          <div class="absolute -top-4 -left-2 z-20 hidden items-center gap-2 rounded-xl border border-slate-200/90 bg-white/95 px-3.5 py-1.5 shadow-md backdrop-blur-xs sm:flex">
            <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
              <Layout class="h-3.5 w-3.5" aria-hidden="true" />
            </div>
            <span class="text-xs font-bold text-slate-800">دیزاین سیستم اختصاصی UI/UX</span>
          </div>

          <!-- Floating Badge 2 (Bottom Right in RTL) -->
          <div class="absolute -bottom-4 -right-2 z-20 hidden items-center gap-2 rounded-xl border border-slate-200/90 bg-white/95 px-3.5 py-1.5 shadow-md backdrop-blur-xs sm:flex">
            <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
              <ShieldCheck class="h-3.5 w-3.5" aria-hidden="true" />
            </div>
            <span class="text-xs font-bold text-slate-800">معماری امن و تست‌شده</span>
          </div>

          <!-- Main Browser Container -->
          <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60">
            <!-- Browser Header Bar -->
            <div class="flex items-center justify-between border-b border-slate-200/80 bg-slate-100/90 px-4 py-2.5">
              <div class="flex items-center gap-1.5">
                <span class="h-2.5 w-2.5 rounded-full bg-red-400/90"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-amber-400/90"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/90"></span>
              </div>

              <!-- Address Bar -->
              <div class="flex items-center gap-1.5 rounded-md border border-slate-200/90 bg-white px-3 py-1 font-mono text-[11px] text-slate-600 shadow-2xs">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                <span>https://solmir.digital/studio</span>
              </div>

              <!-- Viewport Switcher Mock -->
              <div class="flex items-center gap-2 text-slate-400">
                <Monitor class="h-3.5 w-3.5 text-blue-600" aria-hidden="true" />
                <Tablet class="h-3.5 w-3.5" aria-hidden="true" />
                <Smartphone class="h-3.5 w-3.5" aria-hidden="true" />
              </div>
            </div>

            <!-- Browser Interior: Technical Canvas -->
            <div class="relative bg-slate-50/50 p-4 sm:p-5">
              <!-- Grid background -->
              <div class="pointer-events-none absolute inset-0 bg-tech-grid opacity-30"></div>

              <div class="relative z-10 space-y-4">
                <!-- If Hero portfolio image is present, show inside browser -->
                <div v-if="heroPortfolio && heroPortfolio.image" class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
                  <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/70 px-3 py-1.5 text-[10px]">
                    <span class="font-mono text-slate-400">PROJ_VIEW // {{ heroPortfolio.slug }}</span>
                    <span class="rounded-full bg-blue-100 px-2 py-0.5 font-bold text-blue-700">نمونه‌کار شاخص</span>
                  </div>
                  <img :src="heroPortfolio.image.startsWith('http') ? heroPortfolio.image : '/storage/' + heroPortfolio.image" :alt="'نمای پروژه ' + heroPortfolio.title" fetchpriority="high" class="aspect-[16/9] w-full object-cover transition-transform duration-300 group-hover:scale-102" />
                  <div class="flex items-center justify-between border-t border-slate-100 p-3">
                    <div>
                      <p class="text-xs font-bold text-slate-900">{{ heroPortfolio.title }}</p>
                      <p v-if="heroPortfolio.client_name" class="text-[11px] text-slate-500">{{ heroPortfolio.client_name }}</p>
                    </div>
                    <Link :href="route('portfolio.show', heroPortfolio.slug)" class="inline-flex items-center gap-1 text-xs font-bold text-blue-700 hover:text-blue-800">
                      مشاهده <ArrowLeft class="h-3.5 w-3.5" />
                    </Link>
                  </div>
                </div>

                <!-- Abstract UI & Code Panels Composition -->
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                  <!-- Abstract UI Canvas Panel with Designer Cursor -->
                  <div class="relative rounded-xl border border-slate-200/90 bg-white p-3.5 shadow-2xs">
                    <div class="mb-2 flex items-center justify-between border-b border-slate-100 pb-2 text-[10px]">
                      <span class="font-mono font-bold text-slate-400">LAYOUT_GRID</span>
                      <span class="font-mono text-blue-600">[1280 × 800]</span>
                    </div>

                    <!-- Mini Mock Wireframe -->
                    <div class="space-y-2">
                      <div class="flex items-center justify-between rounded-md bg-slate-100 p-1.5">
                        <div class="h-2 w-12 rounded bg-blue-500/80"></div>
                        <div class="flex gap-1">
                          <div class="h-1.5 w-4 rounded bg-slate-300"></div>
                          <div class="h-1.5 w-4 rounded bg-slate-300"></div>
                        </div>
                      </div>
                      <div class="rounded-lg border border-dashed border-blue-300 bg-blue-50/50 p-2 text-center">
                        <div class="mx-auto h-2 w-24 rounded bg-slate-700"></div>
                        <div class="mx-auto mt-1 h-1.5 w-32 rounded bg-slate-400"></div>
                        <div class="mx-auto mt-2 h-4 w-16 rounded bg-blue-600"></div>
                      </div>
                    </div>

                    <!-- Designer Cursor Motif -->
                    <div class="pointer-events-none absolute right-10 bottom-3 flex items-center gap-1.5 drop-shadow-md">
                      <svg class="h-4 w-4 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4 0l16 12.279-6.951 1.17 4.325 8.817-3.596 1.734-4.35-8.879-5.428 5.428v-20.549z" />
                      </svg>
                      <span class="rounded-md bg-blue-600 px-1.5 py-0.5 text-[9px] font-bold text-white shadow-xs">سلمیر (UI/UX)</span>
                    </div>
                  </div>

                  <!-- Code Fragment & Performance Metrics -->
                  <div class="flex flex-col justify-between rounded-xl border border-slate-800 bg-slate-900 p-3.5 text-slate-300 shadow-md">
                    <div>
                      <div class="mb-2 flex items-center justify-between border-b border-slate-800 pb-1.5 text-[10px] text-slate-400">
                        <span class="flex items-center gap-1 font-mono"><Terminal class="h-3 w-3 text-blue-400" /> SolmirEngine.vue</span>
                        <span class="font-bold text-emerald-400">● 100% Passed</span>
                      </div>
                      <div class="space-y-0.5 font-mono text-[10px] leading-relaxed" dir="ltr">
                        <p><span class="text-purple-400">const</span> <span class="text-sky-300">stack</span> = [<span class="text-emerald-300">'Vue 3'</span>, <span class="text-emerald-300">'Laravel 12'</span>];</p>
                        <p><span class="text-purple-400">export</span> <span class="text-blue-300">default</span> defineStudio({</p>
                        <p class="pl-2"><span class="text-slate-400">precision:</span> <span class="text-amber-300">'Pixel-Perfect'</span>,</p>
                        <p class="pl-2"><span class="text-slate-400">typeSafe:</span> <span class="text-blue-400">true</span></p>
                        <p>});</p>
                      </div>
                    </div>

                    <!-- Mini Core Web Vitals Row -->
                    <div class="mt-3 flex items-center justify-between border-t border-slate-800 pt-2 font-mono text-[9px] text-slate-400" dir="ltr">
                      <span class="text-emerald-400">LCP: 0.7s</span>
                      <span class="text-emerald-400">TTFB: 32ms</span>
                      <span class="text-emerald-400">CLS: 0.00</span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 2. INTERACTIVE COLLABORATION JOURNEY -->
    <section class="border-y border-slate-200 bg-slate-50/90 py-14 lg:py-20 relative overflow-hidden">
      <!-- Subtle Background Grid -->
      <div class="pointer-events-none absolute inset-0 bg-tech-grid opacity-30 [mask-image:radial-gradient(ellipse_at_center,black_40%,transparent_90%)]"></div>

      <div class="ui-container relative z-10">

        <!-- ======================================================== -->
        <!-- DESKTOP & TABLET EXPERIENCE (Visible on lg and larger)   -->
        <!-- ======================================================== -->
        <div class="hidden lg:block">
          <!-- Section Header with Controls -->
          <div class="mb-10 flex items-end justify-between">
            <div>
              <div class="inline-flex items-center gap-2 rounded-md border border-blue-200/80 bg-blue-50 px-2.5 py-1 text-xs font-mono font-bold text-blue-700">
                <Workflow class="h-3.5 w-3.5" aria-hidden="true" />
                <span>// COLLABORATION_PIPELINE</span>
              </div>
              <h2 class="mt-2 text-3xl font-black text-slate-900 lg:text-4xl">
                مسیر هوشمند همکاری با سلمیر
              </h2>
              <p class="mt-2 max-w-xl text-sm text-slate-600 leading-relaxed">
                فرآیند ۵ مرحله‌ای شفاف، چابک و مهندسی‌شده؛ برای اجرای دقیق پروژه‌تان بدون ابهام یا دوباره‌کاری.
              </p>
            </div>

            <!-- Controls: Step Counter & Manual Stepping -->
            <div class="flex items-center gap-3">
              <!-- Step Counter Badge -->
              <div class="inline-flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-2xs">
                <span class="text-blue-600">گام {{ activeJourneyStep + 1 }} از {{ journeySteps.length }}</span>
                <span class="text-slate-300">|</span>
                <span class="text-slate-600">پیشرفت کل: <strong class="text-blue-700">{{ journeyProgressPercent }}٪</strong></span>
              </div>

              <!-- Prev / Next Step Buttons -->
              <div class="inline-flex rounded-xl border border-slate-200 bg-white p-1 shadow-2xs">
                <button
                  type="button"
                  @click="prevJourneyStep"
                  aria-label="گام قبلی"
                  class="rounded-lg p-2 text-slate-600 transition-all hover:bg-slate-100 cursor-pointer"
                >
                  <ChevronRight class="h-4 w-4" aria-hidden="true" />
                </button>
                <button
                  type="button"
                  @click="nextJourneyStep(true)"
                  aria-label="گام بعدی"
                  class="rounded-lg p-2 text-slate-600 transition-all hover:bg-slate-100 cursor-pointer"
                >
                  <ChevronLeft class="h-4 w-4" aria-hidden="true" />
                </button>
              </div>
            </div>
          </div>

          <!-- Refined Stepper Progress Track (Desktop) -->
          <div class="relative mb-10">
            <!-- Background Connecting Conduit Line -->
            <div class="absolute top-1/2 right-8 left-8 -z-0 h-1.5 -translate-y-1/2 rounded-full bg-slate-200/80">
              <div
                class="h-full rounded-full bg-gradient-to-l from-blue-600 via-sky-500 to-emerald-500 transition-all duration-700 ease-out"
                :style="{ width: `${(activeJourneyStep / (journeySteps.length - 1)) * 100}%` }"
              ></div>
            </div>

            <!-- 5 Step Cards Row -->
            <div class="relative z-10 grid grid-cols-5 gap-3.5" role="tablist">
              <button
                v-for="(step, idx) in journeySteps"
                :key="step.id"
                type="button"
                role="tab"
                :aria-selected="activeJourneyStep === idx"
                @click="setJourneyStep(idx)"
                class="group relative flex flex-col items-center justify-between gap-3 overflow-hidden rounded-2xl border p-4 text-center transition-all duration-200 cursor-pointer bg-white"
                :class="activeJourneyStep === idx
                  ? 'border-blue-600 shadow-md ring-2 ring-blue-500/20 translate-y-[-2px]'
                  : (idx < activeJourneyStep
                    ? 'border-emerald-200/90 bg-emerald-50/20 text-slate-700 hover:border-emerald-300'
                    : 'border-slate-200/90 text-slate-500 hover:border-slate-300 hover:bg-slate-50')"
              >
                <!-- Card Header: Step Icon Circle -->
                <div
                  class="flex h-9 w-9 items-center justify-center rounded-xl text-xs font-bold transition-all shrink-0"
                  :class="activeJourneyStep === idx
                    ? 'bg-blue-600 text-white shadow-sm ring-4 ring-blue-100 scale-105'
                    : (idx < activeJourneyStep
                      ? 'bg-emerald-600 text-white ring-2 ring-emerald-200'
                      : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200')"
                >
                  <Check v-if="idx < activeJourneyStep" class="h-4 w-4" aria-hidden="true" />
                  <span v-else>{{ step.stepNumber }}</span>
                </div>

                <!-- Title & Phase Badge -->
                <div class="space-y-0.5 w-full">
                  <span class="block text-xs font-bold transition-colors truncate" :class="activeJourneyStep === idx ? 'text-blue-900 font-extrabold' : 'text-slate-700'">
                    {{ step.shortTitle }}
                  </span>
                  <span class="block text-[10px] font-medium truncate" :class="activeJourneyStep === idx ? 'text-blue-600 font-bold' : 'text-slate-400'">
                    {{ step.badge }}
                  </span>
                </div>

                <!-- Integrated Inset Progress Meter Component -->
                <div class="w-full pt-1">
                  <!-- Progress Track Pill with explicit distinct keys to prevent node reuse -->
                  <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                    <div
                      v-if="idx < activeJourneyStep"
                      :key="'done-' + idx"
                      class="h-full w-full rounded-full bg-emerald-500 transition-all duration-300"
                    ></div>
                    <div
                      v-else-if="activeJourneyStep === idx"
                      :key="'active-' + idx + '-' + timerKey"
                      class="h-full rounded-full bg-gradient-to-r from-blue-600 via-sky-500 to-blue-600 journey-timer-bar shadow-xs"
                    ></div>
                    <div
                      v-else
                      :key="'idle-' + idx"
                      class="h-full w-0 bg-transparent"
                    ></div>
                  </div>

                  <!-- Micro-Status Badge -->
                  <div class="mt-2 flex items-center justify-center text-[11px] font-medium leading-none">
                    <span v-if="idx < activeJourneyStep" class="font-bold text-emerald-600 flex items-center gap-1">
                      <span>تکمیل شد</span>
                      <span class="text-xs">✓</span>
                    </span>
                    <span v-else-if="activeJourneyStep === idx" class="font-bold text-blue-600 flex items-center gap-1.5">
                      <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-600"></span>
                      </span>
                      <span>در حال اجرا</span>
                    </span>
                    <span v-else class="text-slate-400">در انتظار</span>
                  </div>
                </div>

                <!-- Bottom Edge Accent Line -->
                <div v-if="activeJourneyStep === idx" class="absolute bottom-0 inset-x-0 h-0.5 bg-blue-600"></div>
                <div v-else-if="idx < activeJourneyStep" class="absolute bottom-0 inset-x-0 h-0.5 bg-emerald-500"></div>
              </button>
            </div>
          </div>

          <!-- Main Desktop Showcase Grid (Details + Live Simulator Canvas) -->
          <div class="grid items-stretch gap-8 lg:grid-cols-12">

            <!-- Right Column: Step Description, Deliverables & Actions -->
            <div class="flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-8 shadow-sm lg:col-span-5">
              <Transition name="journey-content" mode="out-in">
                <div :key="activeJourneyStep" class="space-y-6">
                  <!-- Phase Header -->
                  <div>
                    <div class="mb-2 inline-flex items-center gap-2 font-mono text-xs font-bold text-blue-600">
                      <span class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
                      <span>{{ journeySteps[activeJourneyStep].phaseCode }}</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 leading-tight">
                      {{ journeySteps[activeJourneyStep].title }}
                    </h3>
                  </div>

                  <!-- Description -->
                  <p class="text-sm leading-8 text-slate-600">
                    {{ journeySteps[activeJourneyStep].description }}
                  </p>

                  <!-- Key Deliverables Checklist -->
                  <div class="space-y-2.5 rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                    <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                      <CheckCircle2 class="h-4 w-4 text-emerald-600" />
                      <span>خروجی‌های ملموس این مرحله:</span>
                    </div>
                    <ul class="space-y-2 text-xs text-slate-700 font-medium">
                      <li v-for="(item, dIdx) in journeySteps[activeJourneyStep].deliverables" :key="dIdx" class="flex items-start gap-2">
                        <span class="mt-1.5 h-1.5 w-1.5 rounded-full bg-blue-600 shrink-0"></span>
                        <span>{{ item }}</span>
                      </li>
                    </ul>
                  </div>

                  <!-- Highlight Quote -->
                  <blockquote class="border-r-2 border-blue-500 pr-3.5 text-xs italic text-slate-600 font-medium">
                    «{{ journeySteps[activeJourneyStep].highlightQuote }}»
                  </blockquote>
                </div>
              </Transition>

              <!-- Bottom Action Row -->
              <div class="mt-8 flex items-center justify-between pt-6 border-t border-slate-100">
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                  <ShieldCheck class="h-4 w-4 text-emerald-600" aria-hidden="true" />
                  <span class="text-slate-600">استاندارد کیفی و مهندسی <strong>سلمیر استودیو</strong></span>
                </div>

                <div class="flex items-center gap-2">
                  <button
                    type="button"
                    @click="nextJourneyStep(true)"
                    class="ui-button ui-button-primary px-4 py-2 text-xs font-bold cursor-pointer"
                  >
                    <span>گام بعدی</span>
                    <ArrowLeft class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" aria-hidden="true" />
                  </button>
                  <Link
                    :href="route('orders.create')"
                    class="ui-button ui-button-secondary px-3.5 py-2 text-xs font-bold"
                  >
                    شروع پروژه
                  </Link>
                </div>
              </div>
            </div>

            <!-- Left Column: Live Interactive Visual Simulation Canvas -->
            <div class="relative flex flex-col rounded-3xl border border-slate-200 bg-slate-900 p-1 shadow-xl lg:col-span-7 overflow-hidden">
              <!-- Canvas Header Bar -->
              <div class="flex items-center justify-between border-b border-slate-800 bg-slate-950 px-4 py-3 text-xs">
                <div class="flex items-center gap-2">
                  <div class="flex items-center gap-1.5">
                    <span class="h-2.5 w-2.5 rounded-full bg-red-500/80"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500/80"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500/80"></span>
                  </div>
                  <span class="mr-2 font-mono text-[11px] text-slate-400">
                    SIMULATION // {{ journeySteps[activeJourneyStep].id.toUpperCase() }}
                  </span>
                </div>

                <!-- Live Indicator -->
                <div class="flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-950/60 px-2.5 py-0.5 text-[11px] font-bold text-emerald-400">
                  <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                  <span>شبیه‌ساز زنده فاز</span>
                </div>
              </div>

              <!-- Canvas Dynamic Body with Vue Transition -->
              <div class="relative flex-1 p-6 sm:p-7 flex flex-col justify-center min-h-[420px] bg-slate-900">
                <div class="pointer-events-none absolute inset-0 bg-tech-grid-dark opacity-35"></div>

                <Transition name="journey-canvas" mode="out-in">
                  <!-- 1. Discovery Blueprint Simulator -->
                  <div v-if="activeJourneyStep === 0" key="step-0" class="relative z-10 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                      <span class="font-mono text-xs font-bold text-sky-400">PROJECT_BLUEPRINT_v1.0.spec</span>
                      <span class="rounded bg-sky-950 px-2 py-0.5 font-mono text-[10px] text-sky-300 border border-sky-800">LOCKED_IN</span>
                    </div>

                    <!-- 3 Pillar Spec Cards -->
                    <div class="grid grid-cols-3 gap-3">
                      <div class="rounded-xl border border-slate-800 bg-slate-950/70 p-3.5 space-y-1.5">
                        <div class="text-[11px] font-bold text-slate-300">پرسونا و رفتار کاربر</div>
                        <p class="text-[10px] text-slate-400 leading-relaxed">تحلیل مسیر تصمیم‌گیری مشتری و کاهش اصطکاک پرداخت</p>
                        <div class="h-1.5 w-full rounded-full bg-slate-800 overflow-hidden">
                          <div class="h-full w-full bg-blue-500"></div>
                        </div>
                      </div>

                      <div class="rounded-xl border border-slate-800 bg-slate-950/70 p-3.5 space-y-1.5">
                        <div class="text-[11px] font-bold text-slate-300">معماری پایگاه داده</div>
                        <p class="text-[10px] text-slate-400 leading-relaxed">طراحی روابط بهینه بدون کوئری‌های تکراری و سربار</p>
                        <div class="h-1.5 w-full rounded-full bg-slate-800 overflow-hidden">
                          <div class="h-full w-full bg-emerald-500"></div>
                        </div>
                      </div>

                      <div class="rounded-xl border border-slate-800 bg-slate-950/70 p-3.5 space-y-1.5">
                        <div class="text-[11px] font-bold text-slate-300">معماری سئو و تبدیل</div>
                        <p class="text-[10px] text-slate-400 leading-relaxed">ساختار معنایی URLها و بارگذاری فوق سریع اولیه</p>
                        <div class="h-1.5 w-full rounded-full bg-slate-800 overflow-hidden">
                          <div class="h-full w-full bg-purple-500"></div>
                        </div>
                      </div>
                    </div>

                    <!-- Tech Stack Matrix Pills -->
                    <div class="rounded-xl border border-slate-800 bg-slate-950/90 p-3 font-mono text-xs">
                      <div class="text-[10px] text-slate-500 mb-2">SYSTEM_CAPABILITIES:</div>
                      <div class="flex flex-wrap gap-1.5">
                        <span class="rounded border border-slate-700 bg-slate-800/80 px-2 py-0.5 text-[11px] text-slate-300">RESTful API</span>
                        <span class="rounded border border-slate-700 bg-slate-800/80 px-2 py-0.5 text-[11px] text-slate-300">Role-Based Access</span>
                        <span class="rounded border border-slate-700 bg-slate-800/80 px-2 py-0.5 text-[11px] text-slate-300">Redis Cache</span>
                        <span class="rounded border border-slate-700 bg-slate-800/80 px-2 py-0.5 text-[11px] text-slate-300">PostgreSQL / MySQL</span>
                        <span class="rounded border border-slate-700 bg-slate-800/80 px-2 py-0.5 text-[11px] text-emerald-400">Core Web Vitals A+</span>
                      </div>
                    </div>
                  </div>

                  <!-- 2. UI/UX Figma Canvas Simulator -->
                  <div v-else-if="activeJourneyStep === 1" key="step-1" class="relative z-10 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                      <span class="font-mono text-xs font-bold text-purple-400">Figma // Solmir_DesignSystem_v2.fig</span>
                      <span class="text-xs text-slate-400 font-mono">100% Zoom [Desktop 1440px]</span>
                    </div>

                    <!-- Design Tokens Preview -->
                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-3.5 space-y-2.5">
                      <div class="text-[11px] font-bold text-slate-300">توکن‌های دیزاین سیستم اختصاصی:</div>
                      <div class="grid grid-cols-4 gap-2 text-center font-mono text-[10px]">
                        <div class="rounded-lg border border-slate-700 bg-blue-600 p-2 text-white font-bold">#2563eb<br><span class="text-[9px] opacity-80">Primary</span></div>
                        <div class="rounded-lg border border-slate-700 bg-sky-500 p-2 text-white font-bold">#0ea5e9<br><span class="text-[9px] opacity-80">Accent</span></div>
                        <div class="rounded-lg border border-slate-700 bg-slate-900 p-2 text-slate-200 font-bold border-slate-700">#0f172a<br><span class="text-[9px] opacity-80">Ink Dark</span></div>
                        <div class="rounded-lg border border-slate-700 bg-slate-100 p-2 text-slate-900 font-bold">#f8fafc<br><span class="text-[9px] opacity-80">Canvas</span></div>
                      </div>
                    </div>

                    <!-- Interactive Prototype Wireframe Area with Designer Cursor -->
                    <div class="relative rounded-xl border border-dashed border-purple-500/40 bg-purple-950/20 p-4 text-center">
                      <div class="mx-auto max-w-xs space-y-2">
                        <div class="h-2.5 w-3/4 mx-auto rounded bg-slate-700"></div>
                        <div class="h-2 w-1/2 mx-auto rounded bg-slate-800"></div>
                        <div class="mt-3 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white shadow-lg shadow-blue-500/30">
                          <span>پیش‌نمایش کلیک‌خور در فیگما</span>
                        </div>
                      </div>

                      <!-- Designer Cursor Motif -->
                      <div class="pointer-events-none absolute right-12 bottom-4 flex items-center gap-1.5 drop-shadow-md">
                        <svg class="h-4 w-4 text-purple-400" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M4 0l16 12.279-6.951 1.17 4.325 8.817-3.596 1.734-4.35-8.879-5.428 5.428v-20.549z" />
                        </svg>
                        <span class="rounded bg-purple-600 px-1.5 py-0.5 text-[9px] font-bold text-white">سلمیر دیزاین (Figma UX)</span>
                      </div>
                    </div>
                  </div>

                  <!-- 3. Engineering & Clean Code Simulator -->
                  <div v-else-if="activeJourneyStep === 2" key="step-2" class="relative z-10 space-y-3 font-mono">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-2 text-xs">
                      <div class="flex items-center gap-2">
                        <span class="rounded bg-slate-800 px-2 py-0.5 text-blue-400">OrderEngine.vue</span>
                        <span class="text-slate-500">routes/api.php</span>
                      </div>
                      <span class="text-emerald-400 text-[11px]">● Clean Code & Tested</span>
                    </div>

                    <!-- Code block -->
                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-3.5 text-[11px] leading-relaxed text-slate-300" dir="ltr">
                      <p><span class="text-purple-400">export default</span> <span class="text-blue-400">defineComponent</span>({</p>
                      <p class="pl-3"><span class="text-slate-400">name:</span> <span class="text-emerald-300">'SolmirEngine'</span>,</p>
                      <p class="pl-3"><span class="text-slate-400">setup()</span> {</p>
                      <p class="pl-6"><span class="text-purple-400">const</span> stack = [<span class="text-amber-300">'Vue 3'</span>, <span class="text-amber-300">'Laravel 12'</span>];</p>
                      <p class="pl-6"><span class="text-purple-400">return</span> { architecture: <span class="text-sky-300">'Clean & Modular'</span>, security: <span class="text-blue-400">true</span> };</p>
                      <p class="pl-3">}</p>
                      <p>});</p>
                    </div>

                    <!-- Terminal status bar -->
                    <div class="rounded-xl border border-slate-800 bg-black/60 p-2.5 text-[10px] space-y-1 text-slate-400" dir="ltr">
                      <div class="flex items-center justify-between">
                        <span class="text-emerald-400">✓ 15 PHPUnit Tests passed (50 assertions)</span>
                        <span class="text-slate-500">0ms</span>
                      </div>
                      <div class="flex items-center justify-between">
                        <span class="text-sky-400">✓ Vite build: 2325 modules transformed</span>
                        <span class="text-slate-500">1.1s</span>
                      </div>
                    </div>
                  </div>

                  <!-- 4. QA & Performance Audit Simulator -->
                  <div v-else-if="activeJourneyStep === 3" key="step-3" class="relative z-10 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                      <span class="font-mono text-xs font-bold text-emerald-400">Lighthouse & Core Web Vitals Audit</span>
                      <span class="rounded bg-emerald-950 px-2 py-0.5 font-mono text-[10px] text-emerald-300 border border-emerald-800">GRADE A+</span>
                    </div>

                    <!-- 4 Circular Score Gauges -->
                    <div class="grid grid-cols-4 gap-3 text-center">
                      <div class="rounded-xl border border-emerald-900/60 bg-slate-950 p-3 space-y-1">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full border-2 border-emerald-500 font-mono text-base font-bold text-emerald-400">
                          99
                        </div>
                        <span class="block text-[11px] font-bold text-slate-300">سرعت (Perf)</span>
                      </div>

                      <div class="rounded-xl border border-emerald-900/60 bg-slate-950 p-3 space-y-1">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full border-2 border-emerald-500 font-mono text-base font-bold text-emerald-400">
                          100
                        </div>
                        <span class="block text-[11px] font-bold text-slate-300">دسترس‌پذیری</span>
                      </div>

                      <div class="rounded-xl border border-emerald-900/60 bg-slate-950 p-3 space-y-1">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full border-2 border-emerald-500 font-mono text-base font-bold text-emerald-400">
                          100
                        </div>
                        <span class="block text-[11px] font-bold text-slate-300">Best Practices</span>
                      </div>

                      <div class="rounded-xl border border-emerald-900/60 bg-slate-950 p-3 space-y-1">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full border-2 border-emerald-500 font-mono text-base font-bold text-emerald-400">
                          100
                        </div>
                        <span class="block text-[11px] font-bold text-slate-300">سئو تکنیکال</span>
                      </div>
                    </div>

                    <!-- Web Vitals Metric Gauges -->
                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-3 font-mono text-[11px] grid grid-cols-3 gap-2 text-center" dir="ltr">
                      <div class="rounded bg-slate-900 p-2"><span class="text-slate-400 block text-[9px]">LCP</span><strong class="text-emerald-400">0.68s</strong></div>
                      <div class="rounded bg-slate-900 p-2"><span class="text-slate-400 block text-[9px]">FID/INP</span><strong class="text-emerald-400">14ms</strong></div>
                      <div class="rounded bg-slate-900 p-2"><span class="text-slate-400 block text-[9px]">CLS</span><strong class="text-emerald-400">0.00</strong></div>
                    </div>
                  </div>

                  <!-- 5. Cloud Launch & VIP Support Simulator -->
                  <div v-else key="step-4" class="relative z-10 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                      <span class="font-mono text-xs font-bold text-emerald-400">SOLMIR_CLOUD // Client Portal Handover</span>
                      <span class="rounded bg-emerald-950 px-2 py-0.5 font-mono text-[10px] text-emerald-300 border border-emerald-800">ONLINE [99.98%]</span>
                    </div>

                    <!-- Client Panel Card Mockup -->
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4 space-y-3">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600/20 text-blue-400">
                            <ShieldCheck class="h-4 w-4" />
                          </div>
                          <div>
                            <div class="text-xs font-bold text-white">سفارش فعال: وب‌سایت شرکتی و سامانه اختصاصی</div>
                            <div class="text-[10px] text-slate-400">شناسه قرارداد: #SLM-2026-9481</div>
                          </div>
                        </div>
                        <span class="rounded-full bg-emerald-500/20 px-2.5 py-0.5 text-[10px] font-bold text-emerald-400">مستقر شده</span>
                      </div>

                      <!-- SLA & Action Simulator -->
                      <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-800 text-[11px]">
                        <div class="rounded-lg bg-slate-900 p-2 text-slate-300">
                          <span class="text-slate-500 block text-[10px]">پشتیبانی تیکتینگ:</span>
                          <strong class="text-white">پاسخگویی زیر ۳۰ دقیقه</strong>
                        </div>
                        <div class="rounded-lg bg-slate-900 p-2 text-slate-300">
                          <span class="text-slate-500 block text-[10px]">گارانتی رفع باگ:</span>
                          <strong class="text-emerald-400">گارانتی طلایی فعال</strong>
                        </div>
                      </div>
                    </div>

                    <!-- Handover Checklist Badges -->
                    <div class="flex flex-wrap gap-2 text-xs">
                      <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-800 bg-slate-950 px-2.5 py-1 text-slate-300 font-medium">
                        <CheckCircle class="h-3.5 w-3.5 text-emerald-400" /> دسترسی کامل به سورس Git
                      </span>
                      <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-800 bg-slate-950 px-2.5 py-1 text-slate-300 font-medium">
                        <CheckCircle class="h-3.5 w-3.5 text-emerald-400" /> ویدیوهای آموزشی مدیریت سایت
                      </span>
                    </div>
                  </div>
                </Transition>
              </div>
            </div>

          </div>
        </div>

        <!-- ======================================================== -->
        <!-- DEDICATED MOBILE EXPERIENCE (Visible on screens < lg)    -->
        <!-- ======================================================== -->
        <div class="block lg:hidden" @touchstart="handleTouchStart" @touchend="handleTouchEnd">
          <!-- Mobile Header -->
          <div class="mb-4">
            <div class="inline-flex items-center gap-1.5 rounded-md border border-blue-200/80 bg-blue-50 px-2 py-0.5 text-[11px] font-mono font-bold text-blue-700">
              <Workflow class="h-3 w-3" aria-hidden="true" />
              <span>// COLLABORATION_PIPELINE</span>
            </div>
            <h2 class="mt-1.5 text-xl sm:text-2xl font-black text-slate-900">
              مسیر هوشمند همکاری با سلمیر
            </h2>
            <div class="mt-1 flex items-center gap-2 text-xs text-slate-500 font-sans">
              <span class="relative flex h-2 w-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
              </span>
              <span>گام {{ activeJourneyStep + 1 }} از ۵: {{ journeySteps[activeJourneyStep].shortTitle }}</span>
            </div>
          </div>

          <!-- 5-Segment Story-Style Progress Bars -->
          <div class="grid grid-cols-5 gap-1.5 mb-3" aria-hidden="true">
            <div
              v-for="(s, sIdx) in journeySteps"
              :key="s.id"
              class="h-1.5 rounded-full overflow-hidden bg-slate-200"
            >
              <div
                v-if="sIdx < activeJourneyStep"
                :key="'m-done-' + sIdx"
                class="h-full w-full bg-emerald-500 transition-all duration-300"
              ></div>
              <div
                v-else-if="sIdx === activeJourneyStep"
                :key="'m-active-' + sIdx + '-' + timerKey"
                class="h-full bg-blue-600 journey-timer-bar"
              ></div>
              <div
                v-else
                :key="'m-idle-' + sIdx"
                class="h-full w-0 bg-transparent"
              ></div>
            </div>
          </div>

          <!-- Mobile Compact Step Tabs (Horizontal Tap Selector) -->
          <div class="flex items-center gap-1.5 overflow-x-auto pb-2 mb-4 scrollbar-none" role="tablist">
            <button
              v-for="(st, sIdx) in journeySteps"
              :key="st.id"
              type="button"
              role="tab"
              :aria-selected="activeJourneyStep === sIdx"
              @click="setJourneyStep(sIdx)"
              class="shrink-0 flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs font-bold transition-all cursor-pointer shadow-2xs"
              :class="activeJourneyStep === sIdx
                ? 'border-blue-600 bg-blue-600 text-white shadow-xs'
                : (sIdx < activeJourneyStep
                  ? 'border-emerald-200 bg-emerald-50 text-slate-700'
                  : 'border-slate-200 bg-white text-slate-600')"
            >
              <Check v-if="sIdx < activeJourneyStep" class="h-3 w-3 text-emerald-600" aria-hidden="true" />
              <span v-else class="font-mono text-[10px]">{{ st.stepNumber }}</span>
              <span>{{ st.shortTitle }}</span>
            </button>
          </div>

          <!-- Mobile Unified Card with Touch Support -->
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm space-y-4">
            <!-- Phase Badge & Quality Indicator -->
            <div class="flex items-center justify-between text-xs">
              <span class="font-mono font-bold text-blue-600">{{ journeySteps[activeJourneyStep].phaseCode }}</span>
              <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-medium text-emerald-700 border border-emerald-100">
                <ShieldCheck class="h-3 w-3 text-emerald-600" />
                <span>استاندارد مهندسی</span>
              </span>
            </div>

            <!-- Title & Description -->
            <div>
              <h3 class="text-lg font-black text-slate-900 leading-snug">
                {{ journeySteps[activeJourneyStep].stepNumber }}. {{ journeySteps[activeJourneyStep].title }}
              </h3>
              <p class="mt-2 text-xs leading-6 text-slate-600">
                {{ journeySteps[activeJourneyStep].description }}
              </p>
            </div>

            <!-- Deliverables Checklist -->
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 space-y-1.5">
              <div class="text-[11px] font-bold text-slate-800 flex items-center gap-1">
                <CheckCircle2 class="h-3.5 w-3.5 text-emerald-600" />
                <span>خروجی‌های کلیدی این مرحله:</span>
              </div>
              <ul class="space-y-1 text-xs text-slate-700">
                <li v-for="(item, dIdx) in journeySteps[activeJourneyStep].deliverables" :key="dIdx" class="flex items-start gap-1.5">
                  <span class="mt-1 h-1.5 w-1.5 rounded-full bg-blue-600 shrink-0"></span>
                  <span>{{ item }}</span>
                </li>
              </ul>
            </div>

            <!-- Mobile Compact Visual Simulation Widget -->
            <div class="rounded-xl border border-slate-800 bg-slate-950 p-3.5 text-slate-200">
              <div class="mb-2 flex items-center justify-between border-b border-slate-800 pb-2 text-[10px]">
                <div class="flex items-center gap-1.5">
                  <span class="h-2 w-2 rounded-full bg-red-400"></span>
                  <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                  <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                  <span class="mr-1 font-mono text-slate-400">MOCK // {{ journeySteps[activeJourneyStep].id.toUpperCase() }}</span>
                </div>
                <span class="text-emerald-400 font-bold">● زنده</span>
              </div>

              <!-- Step 0 Mobile Sim -->
              <div v-if="activeJourneyStep === 0" class="space-y-2">
                <div class="text-[11px] font-bold text-sky-400 font-mono">SPEC: SRS_v1.0 [APPROVED]</div>
                <div class="grid grid-cols-3 gap-1.5 text-center text-[10px]">
                  <div class="rounded bg-slate-900 p-1.5"><span class="text-slate-400 block text-[9px]">پرسونا</span><strong class="text-blue-400">۱۰۰٪</strong></div>
                  <div class="rounded bg-slate-900 p-1.5"><span class="text-slate-400 block text-[9px]">دیتابیس</span><strong class="text-emerald-400">بهینه</strong></div>
                  <div class="rounded bg-slate-900 p-1.5"><span class="text-slate-400 block text-[9px]">سئو فنی</span><strong class="text-purple-400">۱۰۰٪</strong></div>
                </div>
                <div class="flex flex-wrap gap-1 text-[9px] pt-1 font-mono text-slate-400">
                  <span class="rounded bg-slate-800 px-1.5 py-0.5">RESTful</span>
                  <span class="rounded bg-slate-800 px-1.5 py-0.5">Redis</span>
                  <span class="rounded bg-slate-800 px-1.5 py-0.5">PostgreSQL</span>
                </div>
              </div>

              <!-- Step 1 Mobile Sim -->
              <div v-else-if="activeJourneyStep === 1" class="space-y-2">
                <div class="flex items-center justify-between text-[10px]">
                  <span class="font-mono text-purple-400">Figma Prototype</span>
                  <span class="text-slate-400">توکن‌های دیزاین</span>
                </div>
                <div class="grid grid-cols-4 gap-1 text-center font-mono text-[9px]">
                  <div class="rounded bg-blue-600 p-1 text-white">#2563eb</div>
                  <div class="rounded bg-sky-500 p-1 text-white">#0ea5e9</div>
                  <div class="rounded bg-slate-900 p-1 text-slate-200 border border-slate-700">#0f172a</div>
                  <div class="rounded bg-slate-100 p-1 text-slate-900">#f8fafc</div>
                </div>
                <div class="rounded-lg border border-dashed border-purple-500/40 bg-purple-950/30 p-2 text-center text-xs font-bold text-purple-300">
                  پیش‌نمایش تعاملی کلیک‌خور در فیگما
                </div>
              </div>

              <!-- Step 2 Mobile Sim -->
              <div v-else-if="activeJourneyStep === 2" class="space-y-1.5 font-mono text-[10px]">
                <div class="text-blue-400">// SolmirEngine.vue</div>
                <div class="rounded bg-black/60 p-2 text-slate-300 space-y-0.5" dir="ltr">
                  <p><span class="text-purple-400">const</span> stack = [<span class="text-amber-300">'Vue 3'</span>, <span class="text-amber-300">'Laravel 12'</span>];</p>
                  <p><span class="text-emerald-400">✓ 15 PHPUnit tests passed</span></p>
                  <p><span class="text-sky-400">✓ Vite build: 0 errors</span></p>
                </div>
              </div>

              <!-- Step 3 Mobile Sim -->
              <div v-else-if="activeJourneyStep === 3" class="space-y-2">
                <div class="text-[10px] font-mono text-emerald-400">Google Lighthouse Score</div>
                <div class="grid grid-cols-4 gap-1.5 text-center">
                  <div class="rounded bg-slate-900 p-1.5"><strong class="text-emerald-400 font-mono text-sm block">99</strong><span class="text-[9px] text-slate-400">سرعت</span></div>
                  <div class="rounded bg-slate-900 p-1.5"><strong class="text-emerald-400 font-mono text-sm block">100</strong><span class="text-[9px] text-slate-400">دسترس‌پذیری</span></div>
                  <div class="rounded bg-slate-900 p-1.5"><strong class="text-emerald-400 font-mono text-sm block">100</strong><span class="text-[9px] text-slate-400">اصول وب</span></div>
                  <div class="rounded bg-slate-900 p-1.5"><strong class="text-emerald-400 font-mono text-sm block">100</strong><span class="text-[9px] text-slate-400">سئو فنی</span></div>
                </div>
              </div>

              <!-- Step 4 Mobile Sim -->
              <div v-else class="space-y-2">
                <div class="flex items-center justify-between text-[10px]">
                  <span class="font-mono text-emerald-400">Cloud Live Handover</span>
                  <span class="text-emerald-400 font-bold">آپ‌تایم ۹۹.۹۸٪</span>
                </div>
                <div class="rounded bg-slate-900 p-2 text-xs text-slate-300 flex items-center justify-between">
                  <span>پاسخگویی تیکت: زیر ۳۰ دقیقه</span>
                  <span class="text-emerald-400 font-bold">گارانتی فعال</span>
                </div>
                <div class="text-[10px] text-slate-400">سورس کد کامل Git + ویدیوهای آموزشی تحویل شد</div>
              </div>
            </div>

            <!-- Mobile Navigation Bar (Prev / Next & CTA) -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
              <div class="flex items-center gap-1">
                <button
                  type="button"
                  @click="prevJourneyStep"
                  aria-label="گام قبلی"
                  class="rounded-xl border border-slate-200 bg-slate-50 p-2 text-slate-600 hover:bg-slate-100 cursor-pointer"
                >
                  <ChevronRight class="h-4 w-4" aria-hidden="true" />
                </button>
                <button
                  type="button"
                  @click="nextJourneyStep(true)"
                  aria-label="گام بعدی"
                  class="rounded-xl border border-slate-200 bg-slate-50 p-2 text-slate-600 hover:bg-slate-100 cursor-pointer"
                >
                  <ChevronLeft class="h-4 w-4" aria-hidden="true" />
                </button>
                <span class="text-[11px] font-bold text-slate-500 mr-1.5">
                  {{ activeJourneyStep + 1 }}/۵
                </span>
              </div>

              <Link
                :href="route('orders.create')"
                class="ui-button ui-button-primary px-4 py-2 text-xs font-bold"
              >
                ثبت درخواست پروژه
              </Link>
            </div>
          </div>
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
            محاسبه آنلاین و برآورد هوشمند هزینه پروژه
          </h2>
          <p class="text-slate-600 max-w-xl mx-auto text-sm sm:text-base">
            مشخصات مدنظر خود را مشخص کنید تا در لحظه برآورد شفاف بودجه و خدمات پروژه را مشاهده نمایید.
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
                    <ShieldCheck class="w-4 h-4" />
                    تضمین کیفیت:
                  </span>
                  <span class="font-bold text-emerald-300">گارانتی طلایی رفع باگ</span>
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
    <section class="ui-section relative overflow-hidden bg-white">
      <div class="pointer-events-none absolute inset-0 bg-tech-lines opacity-25"></div>

      <div class="ui-container relative z-10">
        <div class="mb-12 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
          <div class="max-w-2xl">
            <div class="inline-flex items-center gap-1.5 font-mono text-xs font-bold uppercase tracking-wider text-blue-700">
              <span>// SYSTEM_SERVICES</span>
            </div>
            <h2 class="mt-2 text-3xl font-black text-slate-900 sm:text-4xl">راهکارهایی متناسب با نیاز پروژه</h2>
            <p class="mt-3 text-base text-slate-600">از طراحی هویت و تجربه کاربری تا توسعه سامانه‌های اختصاصی و نگهداری بلندمدت.</p>
          </div>
          <Link :href="route('services.index')" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-800">
            مشاهده تمام خدمات <ArrowLeft class="h-4 w-4" />
          </Link>
        </div>

        <div v-if="services.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <ServiceCard v-for="service in services" :key="service.id" :service="service" />
        </div>
        <div v-else class="ui-empty">در حال حاضر خدمتی برای نمایش ثبت نشده است.</div>
      </div>
    </section>

    <!-- 5. WORKFLOW & PROCESS (ENGINEERING TIMELINE) -->
    <section class="relative overflow-hidden bg-slate-950 py-24 text-white">
      <!-- Technical Grid Overlay -->
      <div class="pointer-events-none absolute inset-0 bg-tech-grid-dark opacity-35 [mask-image:radial-gradient(ellipse_at_center,black_60%,transparent_90%)]"></div>

      <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-16 text-center">
          <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/30 bg-blue-950/60 px-3.5 py-1 text-xs font-mono font-bold text-blue-400">
            <Workflow class="h-3.5 w-3.5" />
            <span>ENGINEERING WORKFLOW</span>
          </div>
          <h2 class="mt-3 text-3xl font-black sm:text-4xl">
            پروژه شما چگونه در سلمیر خلق می‌شود؟
          </h2>
          <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-slate-400 sm:text-base">
            چهار گام شفاف و مهندسی‌شده از تحلیل نیازها تا پیاده‌سازی و استقرار.
          </p>
        </div>

        <!-- Timeline Grid -->
        <div class="relative">
          <!-- Desktop Connector Line -->
          <div class="pointer-events-none absolute top-7 right-[8%] left-[8%] z-0 hidden h-[2px] bg-gradient-to-r from-blue-500/10 via-blue-500/60 to-indigo-500/10 lg:block"></div>

          <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Step 1 -->
            <div class="group relative z-10 rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-lg backdrop-blur-xs transition-all duration-200 hover:border-blue-500/60 hover:bg-slate-900">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-blue-500/40 bg-blue-600/20 font-mono text-sm font-bold text-blue-400 shadow-xs transition-colors group-hover:bg-blue-600 group-hover:text-white">
                  ۰۱
                </div>
                <span class="font-mono text-[10px] text-slate-500">PHASE_01</span>
              </div>
              <h3 class="mb-2 text-lg font-bold text-white group-hover:text-blue-400 transition-colors">نیازسنجی و استراتژی</h3>
              <p class="text-xs leading-relaxed text-slate-400">
                تحلیل عمیق هدف بیزینس شما، بررسی رقبا، مخاطبان هدف و انتخاب بهترین معماری فنی.
              </p>
              <div class="mt-4 border-t border-slate-800/80 pt-3 text-[11px] font-mono text-blue-400/80">
                › Architecture Spec
              </div>
            </div>

            <!-- Step 2 -->
            <div class="group relative z-10 rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-lg backdrop-blur-xs transition-all duration-200 hover:border-indigo-500/60 hover:bg-slate-900">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-indigo-500/40 bg-indigo-600/20 font-mono text-sm font-bold text-indigo-400 shadow-xs transition-colors group-hover:bg-indigo-600 group-hover:text-white">
                  ۰۲
                </div>
                <span class="font-mono text-[10px] text-slate-500">PHASE_02</span>
              </div>
              <h3 class="mb-2 text-lg font-bold text-white group-hover:text-indigo-400 transition-colors">طراحی بصری UI/UX</h3>
              <p class="text-xs leading-relaxed text-slate-400">
                طراحی اختصاصی پروتوتایپ در فیگما با هویت برند، انیمیشن‌ها و جریان کاربرپسند.
              </p>
              <div class="mt-4 border-t border-slate-800/80 pt-3 text-[11px] font-mono text-indigo-400/80">
                › Figma Prototype
              </div>
            </div>

            <!-- Step 3 -->
            <div class="group relative z-10 rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-lg backdrop-blur-xs transition-all duration-200 hover:border-sky-500/60 hover:bg-slate-900">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-sky-500/40 bg-sky-600/20 font-mono text-sm font-bold text-sky-400 shadow-xs transition-colors group-hover:bg-sky-600 group-hover:text-white">
                  ۰۳
                </div>
                <span class="font-mono text-[10px] text-slate-500">PHASE_03</span>
              </div>
              <h3 class="mb-2 text-lg font-bold text-white group-hover:text-sky-400 transition-colors">برنامه‌نویسی چابک</h3>
              <p class="text-xs leading-relaxed text-slate-400">
                پیاده‌سازی دقیق فرانت و بک‌اند با Laravel و Vue 3 با بالاترین استانداردهای امنیتی و سرعت.
              </p>
              <div class="mt-4 border-t border-slate-800/80 pt-3 text-[11px] font-mono text-sky-400/80">
                › Clean Code & Tests
              </div>
            </div>

            <!-- Step 4 -->
            <div class="group relative z-10 rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-lg backdrop-blur-xs transition-all duration-200 hover:border-emerald-500/60 hover:bg-slate-900">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-emerald-500/40 bg-emerald-600/20 font-mono text-sm font-bold text-emerald-400 shadow-xs transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                  ۰۴
                </div>
                <span class="font-mono text-[10px] text-slate-500">PHASE_04</span>
              </div>
              <h3 class="mb-2 text-lg font-bold text-white group-hover:text-emerald-400 transition-colors">تست، تحویل و پشتیبانی</h3>
              <p class="text-xs leading-relaxed text-slate-400">
                دیپلوی روی سرور ابری، آموزش کامل مدیریت پنل و همراهی دائم از طریق سیستم تیکتینگ.
              </p>
              <div class="mt-4 border-t border-slate-800/80 pt-3 text-[11px] font-mono text-emerald-400/80">
                › Cloud CI/CD & SLA
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. FEATURED PORTFOLIO (EDITORIAL SHOWCASE) -->
    <section v-if="featuredPortfolios.length" class="ui-section relative overflow-hidden bg-slate-50/70">
      <div class="ui-container relative z-10">
        <div class="mb-12 flex flex-wrap items-end justify-between gap-4">
          <div>
            <span class="font-mono text-xs font-bold uppercase tracking-wider text-blue-700">// CASE_STUDIES</span>
            <h2 class="mt-1 text-3xl font-black text-slate-900 sm:text-4xl">پروژه‌های برگزیده</h2>
            <p class="mt-2 text-sm text-slate-600">نمونه‌هایی از محصولاتی که با رویکرد مهندسی دقیق طراحی و پیاده‌سازی شده‌اند.</p>
          </div>
          <Link :href="route('portfolio.index')" class="ui-button ui-button-secondary">
            مشاهده همه پروژه‌ها <ArrowLeft class="h-4 w-4" aria-hidden="true" />
          </Link>
        </div>

        <div class="space-y-6">
          <!-- Primary Featured Case Study (Editorial Split Layout) -->
          <article v-if="featuredPortfolios[0]" class="ui-card group overflow-hidden border border-slate-200/90 bg-white transition-all duration-200 hover:border-blue-300 hover:shadow-xl">
            <!-- Browser Mock Header on Big Case Study -->
            <div class="flex items-center justify-between border-b border-slate-200/80 bg-slate-100/80 px-4 py-2 text-xs text-slate-500">
              <div class="flex items-center gap-1.5">
                <span class="h-2.5 w-2.5 rounded-full bg-red-400/80"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-amber-400/80"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/80"></span>
                <span class="mr-2 font-mono text-[10px] text-slate-500">SHOWCASE // {{ featuredPortfolios[0].slug }}</span>
              </div>
              <span class="rounded-md bg-blue-100 px-2 py-0.5 text-[11px] font-bold text-blue-700">پروژه ویژه</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 items-center">
              <div class="lg:col-span-7 aspect-[16/10] overflow-hidden bg-slate-100 relative">
                <img
                  v-if="featuredPortfolios[0].image"
                  :src="featuredPortfolios[0].image.startsWith('http') ? featuredPortfolios[0].image : '/storage/' + featuredPortfolios[0].image"
                  :alt="`نمای پروژه ${featuredPortfolios[0].title}`"
                  class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-103"
                  loading="lazy"
                />
                <div v-else class="flex h-full flex-col items-center justify-center gap-3 bg-slate-100 p-8 text-center text-slate-500">
                  <Laptop class="h-10 w-10 text-slate-400" />
                  <span class="text-sm">پیش‌نمایش بصری پروژه</span>
                </div>
              </div>

              <div class="lg:col-span-5 p-6 sm:p-8 flex flex-col justify-between h-full">
                <div>
                  <div class="flex items-center gap-2 mb-3">
                    <span class="rounded-md bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">{{ featuredPortfolios[0].category }}</span>
                    <span v-if="featuredPortfolios[0].client_name" class="text-xs text-slate-500">• {{ featuredPortfolios[0].client_name }}</span>
                  </div>
                  <h3 class="text-2xl sm:text-3xl font-black text-slate-900 leading-snug group-hover:text-blue-900 transition-colors">
                    {{ featuredPortfolios[0].title }}
                  </h3>
                  <p class="mt-4 text-sm leading-7 text-slate-600 line-clamp-4">
                    {{ featuredPortfolios[0].description }}
                  </p>
                </div>

                <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-5">
                  <Link :href="route('portfolio.show', featuredPortfolios[0].slug)" class="ui-button ui-button-primary px-6 py-2.5">
                    بررسی جزئیات پروژه <ArrowLeft class="h-4 w-4" />
                  </Link>
                  <a v-if="featuredPortfolios[0].url" :href="featuredPortfolios[0].url" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-blue-700">
                    مشاهده آنلاین <ExternalLink class="h-3.5 w-3.5" />
                  </a>
                </div>
              </div>
            </div>
          </article>

          <!-- Secondary Projects in Balanced Grid -->
          <div v-if="featuredPortfolios.length > 1" class="grid gap-6 md:grid-cols-2">
            <PortfolioCard
              v-for="portfolio in featuredPortfolios.slice(1)"
              :key="portfolio.id"
              :portfolio="portfolio"
              :featured="false"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- 7. TESTIMONIALS -->
    <section v-if="testimonials.length" class="ui-section relative overflow-hidden bg-white">
      <div class="pointer-events-none absolute inset-0 bg-tech-lines opacity-20"></div>

      <div class="ui-container relative z-10">
        <div class="mb-12">
          <span class="font-mono text-xs font-bold uppercase tracking-wider text-blue-700">// FEEDBACK</span>
          <h2 class="mt-1 text-3xl font-black text-slate-900 sm:text-4xl">تجربه همکاری با سلمیر</h2>
          <p class="mt-2 text-sm text-slate-600">دیدگاه کارفرمایانی که پروژه‌های وب خود را به تیم سلمیر سپردند.</p>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <blockquote v-for="item in testimonials" :key="item.id" class="ui-card group relative flex flex-col overflow-hidden p-6 transition-all duration-200 hover:border-blue-300 hover:shadow-md">
            <div class="pointer-events-none absolute -top-4 -left-4 h-16 w-16 bg-tech-grid opacity-20"></div>
            <div v-if="item.rating" class="mb-4 flex gap-1 text-amber-500" :aria-label="'امتیاز ' + item.rating + ' از ۵'">
              <Star v-for="star in item.rating" :key="star" class="h-4 w-4 fill-current" aria-hidden="true" />
            </div>
            <p class="flex-1 text-sm leading-7 text-slate-700">{{ item.content }}</p>
            <footer class="mt-6 border-t border-slate-100 pt-4">
              <div class="font-bold text-slate-900">{{ item.name }}</div>
              <div v-if="item.company" class="mt-0.5 text-xs text-slate-500">{{ item.company }}</div>
            </footer>
          </blockquote>
        </div>
      </div>
    </section>

    <!-- 8. INTERACTIVE FAQ ACCORDION -->
    <section class="border-t border-slate-200 bg-slate-50/70 py-20">
      <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="mb-14 text-center">
          <div class="inline-flex items-center gap-1.5 rounded-full border border-blue-200/80 bg-blue-100/70 px-3.5 py-1 text-xs font-bold text-blue-700 mb-3 shadow-2xs">
            <HelpCircle class="h-4 w-4" />
            <span>پاسخ به سوالات پرتکرار</span>
          </div>
          <h2 class="text-3xl font-black text-slate-900 sm:text-4xl mb-3">سوالات متداول کارفرمایان</h2>
          <p class="text-sm text-slate-600">پاسخ به مهم‌ترین نکاتی که پیش از سفارش طراحی وب و سامانه مطرح می‌شوند.</p>
        </div>

        <div class="space-y-4">
          <div
            v-for="(faq, index) in faqs"
            :key="index"
            class="rounded-2xl border border-slate-200/90 bg-white overflow-hidden shadow-2xs transition-all hover:border-blue-300"
          >
            <button
              @click="toggleFaq(index)"
              type="button"
              :aria-expanded="faq.isOpen"
              :aria-controls="'faq-answer-' + index"
              class="flex w-full items-center justify-between p-5 text-right font-bold text-slate-900 transition hover:text-blue-600 cursor-pointer"
            >
              <span class="text-base">{{ faq.q }}</span>
              <ChevronDown
                class="h-5 w-5 shrink-0 text-slate-400 transition-transform duration-200"
                :class="{ 'rotate-180 text-blue-600': faq.isOpen }"
              />
            </button>
            <div
              v-show="faq.isOpen"
              :id="'faq-answer-' + index"
              class="border-t border-slate-100 bg-slate-50/60 px-5 pt-2 pb-5 text-sm leading-relaxed text-slate-600"
            >
              {{ faq.a }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 9. FINAL CTA (PREMIUM DIGITAL ENGINEERING CLOSING) -->
    <section class="relative overflow-hidden border-t border-slate-800 bg-slate-950 py-20 text-white lg:py-24">
      <!-- Fine Technical Dot Grid Background -->
      <div class="pointer-events-none absolute inset-0 bg-tech-grid-dark opacity-35 [mask-image:radial-gradient(ellipse_at_center,black_50%,transparent_85%)]"></div>

      <!-- Subtle Corner Guide Accents -->
      <div class="pointer-events-none absolute top-4 left-6 hidden select-none font-mono text-[10px] text-slate-600 lg:block">+ INITIATE_PROJECT // STAGE_FINAL</div>
      <div class="pointer-events-none absolute bottom-4 right-6 hidden select-none font-mono text-[10px] text-slate-600 lg:block">SOLMIR_DEV_CORE +</div>

      <div class="ui-container relative z-10 text-center">
        <div class="mx-auto mb-4 inline-flex items-center gap-2 rounded-full border border-blue-500/30 bg-blue-900/40 px-3.5 py-1 text-xs font-mono font-bold text-blue-300">
          <Terminal class="h-3.5 w-3.5 text-blue-400" />
          <span>گام بعدی: راه‌اندازی پروژه دیجیتال شما</span>
        </div>

        <h2 class="mx-auto max-w-3xl text-3xl font-black leading-snug sm:text-4xl lg:text-5xl">
          برای خلق تجربهٔ وب بعدی‌تان آماده‌اید؟
        </h2>

        <p class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-slate-400 sm:text-base">
          نیاز یا ایدهٔ خود را ثبت کنید تا نقشه راه فنی و برآورد اختصاصی بودجه پروژه را با هم بررسی کنیم.
        </p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
          <Link :href="route('orders.create')" class="ui-button ui-button-primary px-8 py-3.5 text-base shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:shadow-blue-500/35">
            ثبت درخواست پروژه <ArrowLeft class="h-4 w-4" />
          </Link>
          <Link :href="route('contact.index')" class="ui-button border border-slate-700 bg-slate-900/80 px-8 py-3.5 text-base text-white hover:bg-slate-800">
            تماس و مشاوره مستقیم
          </Link>
        </div>

        <!-- Trust & Engineering Guarantees -->
        <div class="mt-12 flex flex-wrap justify-center gap-6 border-t border-slate-800/80 pt-8 text-xs text-slate-400">
          <span class="flex items-center gap-2 font-medium">
            <CheckCircle2 class="h-4 w-4 text-blue-400" /> مشاوره اولیه و تحلیل فنی
          </span>
          <span class="flex items-center gap-2 font-medium">
            <CheckCircle2 class="h-4 w-4 text-blue-400" /> برآورد شفاف و دقیق بودجه
          </span>
          <span class="flex items-center gap-2 font-medium">
            <CheckCircle2 class="h-4 w-4 text-blue-400" /> قرارداد رسمی و پشتیبانی اختصاصی
          </span>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<style scoped>
@keyframes journeyTimer {
  from {
    width: 0%;
  }
  to {
    width: 100%;
  }
}

.journey-timer-bar {
  animation: journeyTimer 15s linear forwards;
}

.journey-canvas-enter-active,
.journey-canvas-leave-active {
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.journey-canvas-enter-from {
  opacity: 0;
  transform: translateY(12px) scale(0.985);
}
.journey-canvas-leave-to {
  opacity: 0;
  transform: translateY(-12px) scale(0.985);
}

.journey-content-enter-active,
.journey-content-leave-active {
  transition: all 0.25s ease-out;
}
.journey-content-enter-from {
  opacity: 0;
  transform: translateX(10px);
}
.journey-content-leave-to {
  opacity: 0;
  transform: translateX(-10px);
}
</style>
