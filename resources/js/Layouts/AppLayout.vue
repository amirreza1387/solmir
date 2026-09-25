<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
  LayoutDashboard,
  ShoppingBag,
  MessageSquare,
  PlusCircle,
  ShieldCheck,
  LogOut,
  Menu,
  X,
  Sparkles,
  Globe,
  ChevronLeft,
  User
} from 'lucide-vue-next';

import FlashMessages from '@/Components/FlashMessages.vue';
import SeoHead from '@/Components/SeoHead.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const currentUrl = computed(() => page.url);
const isMobileMenuOpen = ref(false);

const navItems = [
  { name: 'داشبورد کاربری', href: '/dashboard', routeName: 'dashboard', icon: LayoutDashboard },
  { name: 'پروفایل کاربری', href: '/dashboard/profile', routeName: 'profile.edit', icon: User },
  { name: 'سفارشات من', href: '/dashboard/orders', routeName: 'orders.index', icon: ShoppingBag },
  { name: 'تیکت‌های پشتیبانی', href: '/dashboard/tickets', routeName: 'tickets.index', icon: MessageSquare },
];

const isActive = (href) => {
  if (href === '/dashboard') return currentUrl.value === '/dashboard';
  return currentUrl.value.startsWith(href);
};
</script>

<template>
  <SeoHead noindex />
  <div class="min-h-screen bg-slate-50 flex flex-col md:flex-row text-slate-800" dir="rtl">
    <FlashMessages />

    <!-- Mobile Header -->
    <div class="md:hidden flex items-center justify-between bg-white px-5 py-4 shadow-xs border-b border-slate-200">
      <Link href="/" class="flex items-center gap-2">
        <img src="/apple-touch-icon.png" alt="سلمیر" class="w-8 h-8 rounded-lg object-contain" width="32" height="32" />
        <span class="text-xl font-black text-slate-900">سلمیر</span>
      </Link>

      <button
        @click="isMobileMenuOpen = !isMobileMenuOpen"
        class="flex min-h-11 min-w-11 items-center justify-center rounded-xl text-slate-600 hover:text-blue-600 hover:bg-slate-100 transition"
        :aria-expanded="isMobileMenuOpen"
        aria-controls="customer-sidebar"
        aria-label="فهرست پنل کاربری"
      >
        <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
        <X v-else class="w-6 h-6" />
      </button>
    </div>

    <!-- Sidebar -->
    <aside id="customer-sidebar"
      :class="{'hidden': !isMobileMenuOpen, 'block': isMobileMenuOpen}"
      class="md:block w-full md:w-[272px] bg-white border-l border-slate-200/90 shadow-xs md:min-h-screen shrink-0 z-30"
    >
      <!-- Brand Logo in Desktop Sidebar -->
      <div class="hidden md:flex items-center justify-between p-6 border-b border-slate-100">
        <Link href="/" class="flex items-center gap-3 group">
          <img src="/apple-touch-icon.png" alt="سلمیر" class="w-10 h-10 rounded-xl object-contain shadow-xs group-hover:scale-105 transition" width="40" height="40" />
          <div>
            <div class="text-xl font-black text-slate-900 group-hover:text-blue-600 transition">سلمیر</div>
            <div class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">پنل کاربری مشتریان</div>
          </div>
        </Link>
      </div>

      <!-- Quick Action: New Order Button -->
      <div class="p-4 border-b border-slate-100">
        <Link
          :href="route('orders.create')"
          class="ui-button ui-button-primary w-full"
        >
          <PlusCircle class="w-4 h-4" />
          <span>ثبت سفارش اختصاصی جدید</span>
        </Link>
      </div>

      <!-- Navigation Links -->
      <nav class="p-4 space-y-1.5">
        <Link
          v-for="item in navItems"
          :key="item.href"
          :href="item.href"
          class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-150"
          :class="isActive(item.href)
            ? 'bg-blue-50 text-blue-700 font-bold shadow-xs'
            : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50'"
        >
          <div class="flex items-center gap-3">
            <component :is="item.icon" class="w-5 h-5 opacity-80" />
            <span>{{ item.name }}</span>
          </div>
          <ChevronLeft v-if="isActive(item.href)" class="w-4 h-4 text-blue-600" />
        </Link>

        <!-- Admin Shortcut (if admin) -->
        <Link
          v-if="user && user.role === 'admin'"
          :href="route('admin.dashboard')"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 transition mt-3"
        >
          <ShieldCheck class="w-5 h-5 text-amber-600" />
          <span>ورود به پنل مدیریت ادمین</span>
        </Link>

        <!-- Return to Public Site -->
        <Link
          href="/"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition"
        >
          <Globe class="w-5 h-5 text-slate-400" />
          <span>مشاهده وب‌سایت اصلی</span>
        </Link>

        <!-- Logout Button -->
        <div class="pt-6 mt-6 border-t border-slate-100">
          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold text-red-600 hover:bg-red-50 transition cursor-pointer"
          >
            <LogOut class="w-5 h-5 text-red-500" />
            <span>خروج از حساب</span>
          </Link>
        </div>
      </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <!-- Topbar Desktop -->
      <header class="bg-white border-b border-slate-200 hidden md:block">
        <div class="h-16 max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between">
          <div class="text-xs text-slate-500">
            خوش آمدید، <span class="font-bold text-slate-800">{{ user?.name }}</span>
          </div>

          <div class="flex items-center gap-4">
            <Link
              :href="route('tickets.create')"
              class="text-xs text-blue-600 hover:text-blue-700 font-bold bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200/60 transition"
            >
              + ارسال تیکت سریع
            </Link>

            <Link :href="route('profile.edit')" class="flex items-center gap-2.5 pl-2 border-r border-slate-200 pr-4 hover:opacity-80 transition">
              <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                {{ user?.name?.charAt(0) || 'ک' }}
              </div>
              <div class="text-right">
                <div class="text-xs font-bold text-slate-900">{{ user?.name }}</div>
                <div class="text-[10px] text-slate-400">{{ user?.email }}</div>
              </div>
            </Link>
          </div>
        </div>
      </header>

      <!-- Slot -->
      <main class="p-4 sm:p-6 lg:p-8 flex-1">
        <slot />
      </main>
    </div>

  </div>
</template>
