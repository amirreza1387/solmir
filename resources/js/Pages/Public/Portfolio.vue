<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  Briefcase, 
  Sparkles, 
  ExternalLink, 
  ArrowLeft, 
  FolderGit2, 
  CheckCircle2, 
  Layers 
} from 'lucide-vue-next';

const props = defineProps({
  portfolios: {
    type: Array,
    default: () => []
  },
});

const selectedCategory = ref('all');

const categories = [
  { id: 'all', label: 'همه پروژه‌ها' },
  { id: 'web', label: 'وب‌سایت شرکتی و فروشگاهی' },
  { id: 'uiux', label: 'طراحی UI/UX' },
  { id: 'mobile', label: 'اپلیکیشن و PWA' },
  { id: 'branding', label: 'هویت بصری و برندینگ' },
];

const filteredPortfolios = computed(() => {
  if (selectedCategory.value === 'all') return props.portfolios;
  return props.portfolios.filter(p => {
    const cat = (p.category || '').toLowerCase();
    if (selectedCategory.value === 'web') return cat.includes('web') || cat.includes('site');
    if (selectedCategory.value === 'uiux') return cat.includes('ui') || cat.includes('ux');
    if (selectedCategory.value === 'mobile') return cat.includes('mobile') || cat.includes('app');
    if (selectedCategory.value === 'branding') return cat.includes('brand');
    return true;
  });
});
</script>

<template>
  <Head title="نمونه‌کارهای طراحی وب و پروژه‌های شاخص | سلمیر" />
  
  <PublicLayout>
    <!-- Header Banner -->
    <div class="relative py-20 bg-radial-glow bg-dot-pattern border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-100/80 text-blue-700 text-xs font-bold mb-4">
          <Briefcase class="w-4 h-4" />
          <span>گالری افتخارات ما</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 mb-4">
          نمونه‌کارها و پروژه‌های اجرا شده
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
          گلچینی از پلتفرم‌ها و محصولاتی که با افتخار برای مشتریان ارزشمندمان توسعه داده‌ایم.
        </p>

        <!-- Category Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2 mt-10">
          <button 
            v-for="cat in categories" 
            :key="cat.id"
            type="button"
            @click="selectedCategory = cat.id"
            class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-200"
            :class="selectedCategory === cat.id 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 scale-105' 
              : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200 hover:bg-slate-50'"
          >
            {{ cat.label }}
          </button>
        </div>
      </div>
    </div>

    <!-- Portfolio Grid -->
    <div class="py-20 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div v-if="filteredPortfolios.length === 0" class="text-center py-16 bg-white rounded-3xl border border-slate-200">
          <FolderGit2 class="w-12 h-12 text-slate-300 mx-auto mb-3" />
          <h3 class="text-lg font-bold text-slate-700">پروژه‌ای در این دسته‌بندی یافت نشد</h3>
          <button @click="selectedCategory = 'all'" class="text-blue-600 font-bold text-sm mt-3 hover:underline">
            مشاهده همه پروژه‌ها
          </button>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="portfolio in filteredPortfolios" 
            :key="portfolio.id"
            class="group bg-white rounded-3xl overflow-hidden border border-slate-200 hover:shadow-2xl hover:border-blue-300 transition-all duration-300 flex flex-col justify-between"
          >
            <!-- Styled Window Preview Frame -->
            <div class="h-60 bg-gradient-to-tr from-slate-950 via-slate-900 to-blue-950 p-4 relative overflow-hidden flex flex-col justify-between">
              
              <!-- Window top bar -->
              <div class="flex items-center justify-between z-10">
                <div class="flex items-center gap-1.5">
                  <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
                  <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                  <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                </div>
                <span class="text-[11px] font-mono px-2.5 py-0.5 rounded-full bg-white/10 text-blue-200 backdrop-blur-md">
                  {{ portfolio.category }}
                </span>
              </div>

              <!-- Graphic Mockup Body -->
              <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 shadow-lg transform group-hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between mb-3">
                  <div class="h-2.5 w-20 bg-blue-400/50 rounded-full"></div>
                  <div class="h-2.5 w-12 bg-white/20 rounded-full"></div>
                </div>
                <div class="space-y-2">
                  <div class="h-2 w-full bg-white/15 rounded-full"></div>
                  <div class="h-2 w-3/4 bg-white/15 rounded-full"></div>
                </div>
                <div class="mt-4 flex items-center justify-between text-[11px] text-blue-300 font-mono">
                  <span>{{ portfolio.title }}</span>
                  <ExternalLink class="w-3.5 h-3.5 opacity-70 group-hover:opacity-100" />
                </div>
              </div>

              <div class="text-[10px] text-slate-400 font-mono flex justify-between z-10">
                <span>{{ portfolio.client_name || 'کارفرمای اختصاصی' }}</span>
                <span>Verified Design</span>
              </div>
            </div>

            <!-- Content Area -->
            <div class="p-6 flex-grow flex flex-col justify-between">
              <div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                  {{ portfolio.title }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-6">
                  {{ portfolio.description }}
                </p>
              </div>

              <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <Link 
                  :href="route('portfolio.show', portfolio.slug)"
                  class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1.5"
                >
                  <span>بررسی پرونده و نتایج</span>
                  <ArrowLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
                </Link>

                <a 
                  v-if="portfolio.url" 
                  :href="portfolio.url" 
                  target="_blank" 
                  rel="noopener"
                  class="text-xs text-slate-400 hover:text-slate-700 flex items-center gap-1"
                >
                  <span>سایت زنده</span>
                  <ExternalLink class="w-3 h-3" />
                </a>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>