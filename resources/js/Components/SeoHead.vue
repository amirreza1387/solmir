<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
  canonical: {
    type: String,
    default: '',
  },
  ogType: {
    type: String,
    default: 'website',
  },
  ogImage: {
    type: String,
    default: '',
  },
  noindex: {
    type: Boolean,
    default: false,
  },
  schema: {
    type: [Object, Array],
    default: null,
  },
});

const page = usePage();
const seoConfig = computed(() => page.props.seo || {});

const pageTitle = computed(() => {
  if (props.title) {
    return props.title.includes('سلمیر') || props.title.includes('Solmir')
      ? props.title
      : `${props.title} | سلمیر`;
  }
  return 'سلمیر | آژانس طراحی وب و توسعه پلتفرم‌های دیجیتال';
});

const pageDescription = computed(() => {
  return props.description || seoConfig.value.defaultDescription || 'آژانس طراحی وب و مهندسی نرم‌افزار سلمیر؛ ارائه راهکارهای نوین دیجیتال، طراحی UI/UX و پلتفرم‌های مقیاس‌پذیر.';
});

const canonicalUrl = computed(() => {
  const baseUrl = (seoConfig.value.appUrl || 'https://solmir.ir').replace(/\/+$/, '');
  if (props.canonical && props.canonical.trim() !== '') {
    const raw = props.canonical.trim();
    if (raw.startsWith('http://') || raw.startsWith('https://')) {
      return raw.split('?')[0];
    }
    const cleanPath = raw.startsWith('/') ? raw : `/${raw}`;
    return `${baseUrl}${cleanPath.split('?')[0]}`;
  }
  const path = page.url.split('?')[0];
  return `${baseUrl}${path === '/' ? '' : path}`;
});

const openGraphImage = computed(() => {
  const img = (props.ogImage && props.ogImage.trim() !== '') 
    ? props.ogImage.trim() 
    : (seoConfig.value.ogImage && seoConfig.value.ogImage.trim() !== '' ? seoConfig.value.ogImage.trim() : null);

  if (!img) return null;

  if (img.startsWith('http://') || img.startsWith('https://')) {
    return img;
  }

  const baseUrl = (seoConfig.value.appUrl || 'https://solmir.ir').replace(/\/+$/, '');
  const cleanPath = img.startsWith('/') ? img : `/${img}`;
  return `${baseUrl}${cleanPath}`;
});

const robotsContent = computed(() => {
  return props.noindex
    ? 'noindex, nofollow'
    : 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1';
});

const schemaJson = computed(() => {
  if (!props.schema) return null;
  return JSON.stringify(props.schema);
});
</script>

<template>
  <Head :title="pageTitle">
    <meta name="description" :content="pageDescription" />
    <meta name="robots" :content="robotsContent" />
    <link rel="canonical" :href="canonicalUrl" />

    <!-- Open Graph -->
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" :content="ogType" />
    <meta property="og:title" :content="pageTitle" />
    <meta property="og:description" :content="pageDescription" />
    <meta property="og:url" :content="canonicalUrl" />
    <meta property="og:site_name" content="Solmir" />
    <meta v-if="openGraphImage" property="og:image" :content="openGraphImage" />

    <!-- Twitter / X Card -->
    <meta name="twitter:card" :content="openGraphImage ? 'summary_large_image' : 'summary'" />
    <meta name="twitter:title" :content="pageTitle" />
    <meta name="twitter:description" :content="pageDescription" />
    <meta v-if="openGraphImage" name="twitter:image" :content="openGraphImage" />

    <!-- Structured Data JSON-LD -->
    <component
      :is="'script'"
      v-if="schemaJson"
      type="application/ld+json"
      v-html="schemaJson"
    />
  </Head>
</template>
