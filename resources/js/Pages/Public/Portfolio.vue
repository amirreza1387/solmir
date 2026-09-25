<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';
import { Briefcase } from 'lucide-vue-next';
import PortfolioCard from '@/Components/PortfolioCard.vue';

const props = defineProps({
  portfolios: {
    type: Array,
    default: () => []
  },
});

const selectedCategory = ref('all');

const categoryLabels = {
  'Web Design': 'طراحی وب‌سایت',
  'UI/UX': 'طراحی UI/UX',
  'Mobile App': 'اپلیکیشن موبایل',
  Branding: 'هویت بصری',
};
const categories = computed(() => [
  { id: 'all', label: 'همه پروژه‌ها' },
  ...[...new Set(props.portfolios.map(portfolio => portfolio.category).filter(Boolean))]
    .map(category => ({ id: category, label: categoryLabels[category] || category })),
]);

const filteredPortfolios = computed(() => {
  if (selectedCategory.value === 'all') return props.portfolios;
  return props.portfolios.filter(portfolio => portfolio.category === selectedCategory.value);
});

const portfolioSchema = computed(() => ({
  '@context': 'https://schema.org',
  '@graph': [
    {
      '@type': 'CollectionPage',
      '@id': 'https://solmir.ir/portfolio#webpage',
      'url': 'https://solmir.ir/portfolio',
      'name': 'نمونه‌کارهای طراحی وب و پروژه‌های شاخص | سلمیر',
      'description': 'نمونه‌کارها و پروژه‌های اجرا شده توسط آژانس مهندسی وب سلمیر شامل وب‌سایت‌های شرکتی، فروشگاهی و پلتفرم‌های اختصاصی.',
      'breadcrumb': {
        '@type': 'BreadcrumbList',
        'itemListElement': [
          {
            '@type': 'ListItem',
            'position': 1,
            'name': 'صفحه اصلی',
            'item': 'https://solmir.ir',
          },
          {
            '@type': 'ListItem',
            'position': 2,
            'name': 'نمونه‌کارها',
            'item': 'https://solmir.ir/portfolio',
          },
        ],
      },
    },
  ],
}));
</script>

<template>
  <SeoHead
    title="نمونه‌کارهای طراحی وب و پروژه‌های شاخص | سلمیر"
    description="مشاهده نمونه‌کارهای اجرا شده، پروژه‌های طراحی وب، دیزاین سیستم‌های UI/UX و پلتفرم‌های توسعه‌یافته با بالاترین استاندارد توسط تیم سلمیر."
    :schema="portfolioSchema"
  />

  <PublicLayout>
    <!-- Header Banner -->
    <div class="border-b border-slate-200 bg-white py-16 lg:py-20">
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
            class="min-h-11 rounded-full border px-5 py-2.5 text-xs font-bold transition-colors duration-150 sm:text-sm"
            :aria-pressed="selectedCategory === cat.id"
            :class="selectedCategory === cat.id
              ? 'bg-blue-600 text-white border-blue-600'
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

        <div v-if="filteredPortfolios.length === 0" class="ui-card text-center py-16 px-4">
          <h3 class="text-lg font-bold text-slate-700">پروژه‌ای در این دسته‌بندی یافت نشد</h3>
          <button @click="selectedCategory = 'all'" class="text-blue-600 font-bold text-sm mt-3 hover:underline">
            مشاهده همه پروژه‌ها
          </button>
        </div>

        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
          <PortfolioCard
            v-for="(portfolio, index) in filteredPortfolios"
            :key="portfolio.id"
            :portfolio="portfolio"
            :featured="index === 0 && selectedCategory === 'all'"
            :class="index === 0 && selectedCategory === 'all' ? 'lg:col-span-2' : ''"
          />
        </div>

      </div>
    </div>
  </PublicLayout>
</template>
