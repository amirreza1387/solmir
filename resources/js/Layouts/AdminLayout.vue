<template>
  <div class="min-h-screen bg-slate-50 flex font-sans text-slate-800" dir="rtl">
    <FlashMessages />

    <!-- Sidebar -->
    <aside
      class="fixed inset-y-0 right-0 w-64 bg-slate-900 text-white transition-transform duration-300 z-50 md:translate-x-0 flex flex-col justify-between"
      :class="isSidebarOpen ? 'translate-x-0' : 'translate-x-full'"
    >
      <div>
        <div class="flex items-center justify-between p-5 border-b border-slate-800">
          <Link href="/admin" class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black shadow-md shadow-blue-500/30">
              <ShieldCheck class="w-5 h-5" />
            </div>
            <div>
              <span class="text-lg font-black text-white block">سلمیر</span>
              <span class="text-[10px] text-blue-400 font-bold block -mt-1">پنل مدیریت پیشرفته</span>
            </div>
          </Link>
          <button class="md:hidden text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800" @click="isSidebarOpen = false" aria-label="بستن منو">
            <X class="w-5 h-5" />
          </button>
        </div>

        <nav class="p-4 space-y-1.5">
          <Link
            v-for="item in navItems"
            :key="item.href"
            :href="item.href"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150"
            :class="isCurrent(item.href) ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white'"
          >
            <component :is="item.icon" class="w-4 h-4 shrink-0" />
            <span>{{ item.name }}</span>
          </Link>
        </nav>
      </div>

      <!-- Sidebar Bottom Shortcuts -->
      <div class="p-4 border-t border-slate-800 space-y-1.5">
        <Link
          href="/dashboard"
          class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition"
        >
          <LayoutDashboard class="w-4 h-4 text-slate-500" />
          <span>داشبورد کاربری</span>
        </Link>
        <Link
          href="/"
          class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition"
        >
          <Globe class="w-4 h-4 text-slate-500" />
          <span>مشاهده وب‌سایت اصلی</span>
        </Link>
        <Link
          href="/logout"
          method="post"
          as="button"
          class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-bold text-rose-400 hover:text-rose-300 hover:bg-rose-950/30 transition cursor-pointer text-right"
        >
          <LogOut class="w-4 h-4 text-rose-500" />
          <span>خروج از حساب</span>
        </Link>
      </div>
    </aside>

    <!-- Overlay -->
    <div
      v-if="isSidebarOpen"
      class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 md:hidden"
      @click="isSidebarOpen = false"
    ></div>

    <!-- Main Content -->
    <div class="flex-1 md:mr-64 flex flex-col min-h-screen">
      <!-- Topbar -->
      <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-30">
        <div class="flex items-center gap-4">
          <button class="md:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-lg hover:bg-slate-100" @click="isSidebarOpen = true" aria-label="منو">
            <Menu class="w-5 h-5" />
          </button>
          <h2 class="font-bold text-slate-800 text-sm sm:text-base">سیستم مدیریت سلمیر</h2>
        </div>
        
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
              {{ user?.name?.charAt(0) || 'م' }}
            </div>
            <span class="text-xs font-bold text-slate-700">{{ user?.name }}</span>
          </div>

          <Link
            href="/logout"
            method="post"
            as="button"
            class="text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-rose-50 px-2.5 py-1.5 rounded-lg transition cursor-pointer"
          >
            خروج
          </Link>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-4 sm:p-6 lg:p-8 flex-1">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import FlashMessages from '@/Components/FlashMessages.vue';
import { 
  LayoutDashboard, 
  Users, 
  Layers, 
  Briefcase, 
  ShoppingBag, 
  MessageSquare, 
  Mail, 
  LogOut, 
  Globe, 
  ShieldCheck, 
  Menu, 
  X 
} from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth?.user);

const isSidebarOpen = ref(false);

const navItems = [
  { name: 'داشبورد', href: '/admin', icon: LayoutDashboard },
  { name: 'کاربران', href: '/admin/users', icon: Users },
  { name: 'خدمات', href: '/admin/services', icon: Layers },
  { name: 'نمونه‌کارها', href: '/admin/portfolios', icon: Briefcase },
  { name: 'سفارشات', href: '/admin/orders', icon: ShoppingBag },
  { name: 'تیکت‌ها', href: '/admin/tickets', icon: MessageSquare },
  { name: 'پیام‌های تماس', href: '/admin/contacts', icon: Mail },
];

const isCurrent = (path) => {
  if (path === '/admin') {
    return page.url === '/admin';
  }
  return page.url.startsWith(path);
};
</script>
