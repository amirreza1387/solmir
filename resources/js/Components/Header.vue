<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import {
  Sparkles,
  Layers,
  Briefcase,
  Info,
  PhoneCall,
  LayoutDashboard,
  LogIn,
  UserPlus,
  Menu,
  X,
  ArrowLeft,
  ShieldCheck,
  PlusCircle
} from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const currentUrl = computed(() => page.url);
const isMobileMenuOpen = ref(false);

const navItems = [
  { name: 'صفحه اصلی', href: '/', icon: Sparkles },
  { name: 'خدمات تخصصی', href: '/services', icon: Layers },
  { name: 'نمونه‌کارها', href: '/portfolio', icon: Briefcase },
  { name: 'درباره ما', href: '/about', icon: Info },
  { name: 'تماس با ما', href: '/contact', icon: PhoneCall },
];

const isActive = (href) => {
  if (href === '/') return currentUrl.value === '/';
  return currentUrl.value.startsWith(href);
};
</script>

<template>
  <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between md:h-[68px] lg:h-[72px]">

        <!-- Logo & Brand -->
        <div class="flex items-center gap-8">
          <Link href="/" class="flex items-center gap-3 group">
            <img
              src="/apple-touch-icon.png"
              alt="لوگوی سلمیر"
              class="h-10 w-10 rounded-xl object-contain shadow-xs group-hover:scale-105 transition-transform"
              width="40"
              height="40"
            />
            <div class="flex flex-col">
              <span class="text-[22px] font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                سلمیر
              </span>
              <span class="text-xs font-semibold text-blue-700">
                Solmir Digital
              </span>
            </div>
          </Link>

          <!-- Desktop Navigation -->
          <nav class="hidden lg:flex items-center gap-1" aria-label="ناوبری اصلی">
            <Link
              v-for="item in navItems"
              :key="item.href"
              :href="item.href"
              class="px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-150"
              :class="isActive(item.href)
                ? 'text-blue-700 bg-blue-50 font-bold'
                : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50'"
            >
              <span>{{ item.name }}</span>
            </Link>
          </nav>
        </div>

        <!-- Desktop Action Buttons -->
        <div class="hidden lg:flex items-center gap-3">
          <template v-if="user">
            <Link
              v-if="user.role === 'admin'"
              :href="route('admin.dashboard')"
              class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold rounded-lg bg-amber-50 text-amber-700 border border-amber-200/70 hover:bg-amber-100 transition"
            >
              <ShieldCheck class="w-4 h-4" />
              پنل مدیریت
            </Link>

            <Link
              :href="route('orders.create')"
              class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-xl text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition duration-200"
            >
              <PlusCircle class="w-4 h-4" />
              سفارش جدید
            </Link>

            <Link
              :href="route('dashboard')"
              class="ui-button ui-button-secondary"
            >
              <LayoutDashboard class="w-4 h-4" />
              <span>{{ user.name }}</span>
            </Link>
          </template>

          <template v-else>
            <Link
              :href="route('login')"
              class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-700 hover:text-blue-600 hover:bg-slate-100/70 rounded-xl transition"
            >
              <LogIn class="w-4 h-4 text-slate-500" />
              ورود
            </Link>

            <Link
              :href="route('register')"
              class="ui-button ui-button-primary"
            >
              <UserPlus class="w-4 h-4" />
              <span>شروع همکاری</span>
            </Link>
          </template>
        </div>

        <!-- Mobile Menu Trigger -->
        <div class="flex items-center lg:hidden">
          <button
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="flex h-11 w-11 items-center justify-center rounded-xl text-slate-700 hover:bg-slate-100 hover:text-blue-700"
            aria-label="منو"
            :aria-expanded="isMobileMenuOpen"
            aria-controls="public-mobile-menu"
          >
            <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
            <X v-else class="w-6 h-6" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Drawer -->
    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="isMobileMenuOpen" id="public-mobile-menu" class="max-h-[calc(100dvh-4rem)] overflow-y-auto border-b border-slate-200 bg-white px-4 pb-6 pt-3 shadow-lg lg:hidden">
        <div class="space-y-1">
          <Link
            v-for="item in navItems"
            :key="item.href"
            :href="item.href"
            @click="isMobileMenuOpen = false"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium transition"
            :class="isActive(item.href)
              ? 'text-blue-600 bg-blue-50 font-bold'
              : 'text-slate-700 hover:text-blue-600 hover:bg-slate-50'"
          >
            <component :is="item.icon" class="w-5 h-5 opacity-70" />
            <span>{{ item.name }}</span>
          </Link>
        </div>

        <div class="pt-4 border-t border-slate-100 space-y-2">
          <template v-if="user">
            <Link
              :href="route('orders.create')"
              @click="isMobileMenuOpen = false"
              class="ui-button ui-button-primary w-full"
            >
              <PlusCircle class="h-4 w-4" aria-hidden="true" />
              سفارش جدید
            </Link>
            <Link
              v-if="user.role === 'admin'"
              :href="route('admin.dashboard')"
              @click="isMobileMenuOpen = false"
              class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold bg-amber-50 text-amber-800 border border-amber-200"
            >
              <ShieldCheck class="w-4 h-4" />
              ورود به پنل مدیریت
            </Link>

            <Link
              :href="route('dashboard')"
              @click="isMobileMenuOpen = false"
              class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold bg-blue-600 text-white shadow-md shadow-blue-500/30"
            >
              <LayoutDashboard class="w-4 h-4" />
              داشبورد کاربری ({{ user.name }})
            </Link>
          </template>

          <template v-else>
            <Link
              :href="route('login')"
              @click="isMobileMenuOpen = false"
              class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition"
            >
              <LogIn class="w-4 h-4" />
              ورود به حساب
            </Link>

            <Link
              :href="route('register')"
              @click="isMobileMenuOpen = false"
              class="ui-button ui-button-primary w-full"
            >
              <UserPlus class="w-4 h-4" />
              ثبت‌نام و سفارش پروژه
            </Link>
          </template>
        </div>
      </div>
    </transition>
  </header>
</template>
