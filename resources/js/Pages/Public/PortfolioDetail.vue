<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import SeoHead from '@/Components/SeoHead.vue';
import {
  ArrowLeft,
  ExternalLink,
  Briefcase,
  User,
  Calendar,
  Sparkles,
  Layers
} from 'lucide-vue-next';

const props = defineProps({
  portfolio: {
    type: Object,
    required: true
  },
});

const portfolioItemSchema = computed(() => ({
  '@context': 'https://schema.org',
  '@graph': [
    {
      '@type': 'CreativeWork',
      '@id': `https://solmir.ir/portfolio/${props.portfolio.slug}#work`,
      'name': props.portfolio.title,
      'description': props.portfolio.description,
      'genre': props.portfolio.category,
      'author': {
        '@type': 'Organization',
        'name': 'Solmir',
        'url': 'https://solmir.ir',
      },
    },
    {
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
        {
          '@type': 'ListItem',
          'position': 3,
          'name': props.portfolio.title,
          'item': `https://solmir.ir/portfolio/${props.portfolio.slug}`,
        },
      ],
    },
  ],
}));
</script>

<template>
  <SeoHead
    :title="`${portfolio.title} | نمونه‌کار آژانس سلمیر`"
    :description="portfolio.description"
    :canonical="`https://solmir.ir/portfolio/${portfolio.slug}`"
    :schema="portfolioItemSchema"
  />

  <PublicLayout>
    <div class="py-12 lg:py-20 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Back Link -->
        <Link
          :href="route('portfolio.index')"
          class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 mb-8 bg-white border border-slate-200 px-4 py-2 rounded-xl transition"
        >
          <ArrowLeft class="w-4 h-4 rotate-180" />
          <span>بازگشت به گالری نمونه‌کارها</span>
        </Link>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

          <!-- Main Content (2 cols) -->
          <div class="lg:col-span-2 space-y-8">

            <!-- Project Image or Modern Mockup -->
            <div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-xl">
              <img
                v-if="portfolio.image"
                :src="portfolio.image.startsWith('http') ? portfolio.image : '/storage/' + portfolio.image"
                :alt="portfolio.title"
                fetchpriority="high"
                class="w-full max-h-[500px] object-cover"
              />

              <!-- Image unavailable -->
              <div v-else class="flex h-64 items-center justify-center bg-slate-100 p-8 text-center text-sm text-slate-500">تصویری برای این پروژه ثبت نشده است.</div>
            </div>

            <!-- Title & Description -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs space-y-6">
              <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1 block">{{ portfolio.category }}</span>
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900">{{ portfolio.title }}</h1>
              </div>

              <div class="border-t border-slate-100 pt-6">
                <h3 class="text-base font-bold text-slate-900 mb-4">شرح پروژه و اهداف اجرا:</h3>
                <p class="text-slate-700 leading-relaxed text-sm sm:text-base whitespace-pre-wrap">
                  {{ portfolio.description }}
                </p>
              </div>

            </div>

          </div>

          <!-- Specs Sidebar (1 col) -->
          <div class="space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs space-y-6 sticky top-24">
              <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4">
                شناسنامه پروژه
              </h3>

              <div class="space-y-4 text-xs">
                <div class="flex items-start justify-between">
                  <span class="text-slate-400 flex items-center gap-1.5">
                    <Layers class="w-4 h-4 text-blue-600" />
                    دسته‌بندی:
                  </span>
                  <span class="font-bold text-slate-800">{{ portfolio.category }}</span>
                </div>

                <div v-if="portfolio.client_name" class="flex items-start justify-between">
                  <span class="text-slate-400 flex items-center gap-1.5">
                    <User class="w-4 h-4 text-blue-600" />
                    کارفرما / سازمان:
                  </span>
                  <span class="font-bold text-slate-800">{{ portfolio.client_name }}</span>
                </div>

                <div class="flex items-start justify-between">
                  <span class="text-slate-400 flex items-center gap-1.5">
                    <Calendar class="w-4 h-4 text-blue-600" />
                    تاریخ ثبت:
                  </span>
                  <span class="font-bold text-slate-800 font-mono">{{ new Date(portfolio.created_at).toLocaleDateString('fa-IR') }}</span>
                </div>
              </div>

              <!-- Live URL Button -->
              <div v-if="portfolio.url" class="pt-4 border-t border-slate-100">
                <a
                  :href="portfolio.url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition"
                >
                  <ExternalLink class="w-4 h-4" />
                  <span>مشاهده وب‌سایت آنلاین</span>
                </a>
              </div>

              <!-- Start similar project CTA -->
              <div class="pt-4 border-t border-slate-100">
                <Link
                  :href="route('orders.create')"
                  class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-50 hover:bg-blue-50 text-blue-700 font-bold text-xs border border-slate-200 hover:border-blue-300 transition"
                >
                  <Sparkles class="w-4 h-4" />
                  <span>سفارش پروژه‌ای مشابه این کار</span>
                </Link>
              </div>

            </div>
          </div>

        </div>

      </div>
    </div>
  </PublicLayout>
</template>
