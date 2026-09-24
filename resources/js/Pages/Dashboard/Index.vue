<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { 
  ShoppingBag, 
  MessageSquare, 
  PlusCircle, 
  Clock, 
  CheckCircle2, 
  AlertCircle, 
  ArrowLeft, 
  Sparkles, 
  Layers,
  Send
} from 'lucide-vue-next';

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      activeOrders: 0,
      totalOrders: 0,
      openTickets: 0,
      totalTickets: 0,
    })
  },
  latestOrders: {
    type: Array,
    default: () => []
  },
  latestTickets: {
    type: Array,
    default: () => []
  },
});

const page = usePage();
const user = page.props.auth?.user;

const getStatusBadge = (status) => {
  const map = {
    pending: { label: 'در انتظار بررسی', class: 'bg-amber-100 text-amber-800' },
    confirmed: { label: 'تایید شده', class: 'bg-blue-100 text-blue-800' },
    in_progress: { label: 'در حال انجام', class: 'bg-indigo-100 text-indigo-800' },
    completed: { label: 'تکمیل شده', class: 'bg-emerald-100 text-emerald-800' },
    cancelled: { label: 'لغو شده', class: 'bg-rose-100 text-rose-800' },
  };
  return map[status] || { label: status, class: 'bg-slate-100 text-slate-800' };
};

const getTicketStatusBadge = (status) => {
  const map = {
    open: { label: 'باز', class: 'bg-emerald-100 text-emerald-800' },
    in_progress: { label: 'در حال بررسی', class: 'bg-blue-100 text-blue-800' },
    answered: { label: 'پاسخ داده شده', class: 'bg-purple-100 text-purple-800' },
    closed: { label: 'بسته شده', class: 'bg-slate-100 text-slate-800' },
  };
  return map[status] || { label: status, class: 'bg-slate-100 text-slate-800' };
};
</script>

<template>
  <AppLayout>
    <Head title="داشبورد کاربری | سلمیر" />

    <div class="space-y-8 max-w-7xl mx-auto">
      
      <!-- Welcome Hero Banner -->
      <div class="relative rounded-3xl bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-700 p-6 sm:p-10 text-white shadow-xl overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
          <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 text-xs font-bold mb-3 backdrop-blur-md">
              <Sparkles class="w-3.5 h-3.5" />
              <span>پنل اختصاصی مشتریان سلمیر</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black mb-2">
              خوش آمدید، {{ user?.name }} عزیز 👋
            </h1>
            <p class="text-blue-100 text-xs sm:text-sm max-w-xl leading-relaxed">
              از این بخش می‌توانید وضعیت سفارشات فعال خود را لحظه‌ای پیگیری نمایید و یا از طریق تیکت با تیم پشتیبانی در ارتباط باشید.
            </p>
          </div>

          <div class="flex flex-wrap items-center gap-3">
            <Link 
              :href="route('orders.create')" 
              class="px-5 py-3 rounded-2xl bg-white text-blue-700 hover:bg-blue-50 font-bold text-xs sm:text-sm shadow-md transition flex items-center gap-2"
            >
              <PlusCircle class="w-4 h-4" />
              <span>ثبت سفارش پروژه جدید</span>
            </Link>

            <Link 
              :href="route('tickets.create')" 
              class="px-5 py-3 rounded-2xl bg-blue-800/80 hover:bg-blue-800 border border-blue-400/40 text-white font-bold text-xs sm:text-sm transition flex items-center gap-2"
            >
              <Send class="w-4 h-4" />
              <span>ارسال تیکت پشتیبانی</span>
            </Link>
          </div>
        </div>
      </div>

      <!-- Stat Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
          <div>
            <div class="text-xs font-bold text-slate-500 mb-1">سفارشات در حال انجام</div>
            <div class="text-3xl font-black text-slate-900">{{ stats.activeOrders }}</div>
            <div class="text-[11px] text-blue-600 font-semibold mt-2">پیگیری مداوم وضعیت</div>
          </div>
          <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
            <Clock class="w-6 h-6" />
          </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
          <div>
            <div class="text-xs font-bold text-slate-500 mb-1">مجموع سفارشات شما</div>
            <div class="text-3xl font-black text-slate-900">{{ stats.totalOrders }}</div>
            <div class="text-[11px] text-slate-400 mt-2">سفارش ثبت‌شده در سامانه</div>
          </div>
          <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <ShoppingBag class="w-6 h-6" />
          </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
          <div>
            <div class="text-xs font-bold text-slate-500 mb-1">تیکت‌های در دست اقدام</div>
            <div class="text-3xl font-black text-slate-900">{{ stats.openTickets }}</div>
            <div class="text-[11px] text-emerald-600 font-semibold mt-2">پاسخگویی فنی ۲۴ ساعته</div>
          </div>
          <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <MessageSquare class="w-6 h-6" />
          </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
          <div>
            <div class="text-xs font-bold text-slate-500 mb-1">کل سوابق پشتیبانی</div>
            <div class="text-3xl font-black text-slate-900">{{ stats.totalTickets }}</div>
            <div class="text-[11px] text-slate-400 mt-2">تیکت‌های مطرح‌شده</div>
          </div>
          <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
            <CheckCircle2 class="w-6 h-6" />
          </div>
        </div>

      </div>

      <!-- Two Column Layout: Recent Orders & Recent Tickets -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Latest Orders -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
              <div class="flex items-center gap-2 font-black text-slate-900 text-lg">
                <ShoppingBag class="w-5 h-5 text-blue-600" />
                <span>آخرین سفارشات</span>
              </div>
              <Link :href="route('orders.index')" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                <span>مشاهده همه</span>
                <ArrowLeft class="w-3.5 h-3.5" />
              </Link>
            </div>

            <div v-if="latestOrders.length === 0" class="text-center py-10 text-slate-400">
              <ShoppingBag class="w-10 h-10 mx-auto mb-2 opacity-50" />
              <p class="text-sm">هنوز سفارشی ثبت نکرده‌اید.</p>
              <Link :href="route('orders.create')" class="inline-block mt-3 text-xs font-bold text-blue-600 hover:underline">
                ثبت اولین سفارش
              </Link>
            </div>

            <div v-else class="space-y-3">
              <div 
                v-for="order in latestOrders" 
                :key="order.id"
                class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between hover:bg-blue-50/50 hover:border-blue-200 transition"
              >
                <div>
                  <div class="font-bold text-sm text-slate-900 mb-1">{{ order.title }}</div>
                  <div class="text-xs text-slate-400 font-mono">{{ order.order_number }} • {{ order.service_type }}</div>
                </div>
                <div class="flex items-center gap-3">
                  <span class="px-2.5 py-1 rounded-full text-xs font-bold" :class="getStatusBadge(order.status).class">
                    {{ getStatusBadge(order.status).label }}
                  </span>
                  <Link :href="route('orders.show', order.id)" class="text-xs text-blue-600 hover:text-blue-800 font-bold">
                    جزئیات
                  </Link>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 pt-4 border-t border-slate-100">
            <Link :href="route('orders.create')" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
              <PlusCircle class="w-4 h-4" />
              <span>ثبت سفارش اختصاصی جدید</span>
            </Link>
          </div>
        </div>

        <!-- Latest Tickets -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
              <div class="flex items-center gap-2 font-black text-slate-900 text-lg">
                <MessageSquare class="w-5 h-5 text-emerald-600" />
                <span>آخرین تیکت‌های پشتیبانی</span>
              </div>
              <Link :href="route('tickets.index')" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                <span>مشاهده همه</span>
                <ArrowLeft class="w-3.5 h-3.5" />
              </Link>
            </div>

            <div v-if="latestTickets.length === 0" class="text-center py-10 text-slate-400">
              <MessageSquare class="w-10 h-10 mx-auto mb-2 opacity-50" />
              <p class="text-sm">تیکت فعالی وجود ندارد.</p>
              <Link :href="route('tickets.create')" class="inline-block mt-3 text-xs font-bold text-blue-600 hover:underline">
                ایجاد تیکت پشتیبانی جدید
              </Link>
            </div>

            <div v-else class="space-y-3">
              <div 
                v-for="ticket in latestTickets" 
                :key="ticket.id"
                class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between hover:bg-emerald-50/40 hover:border-emerald-200 transition"
              >
                <div>
                  <div class="font-bold text-sm text-slate-900 mb-1">{{ ticket.title }}</div>
                  <div class="text-xs text-slate-400 font-mono">{{ ticket.ticket_number }}</div>
                </div>
                <div class="flex items-center gap-3">
                  <span class="px-2.5 py-1 rounded-full text-xs font-bold" :class="getTicketStatusBadge(ticket.status).class">
                    {{ getTicketStatusBadge(ticket.status).label }}
                  </span>
                  <Link :href="route('tickets.show', ticket.id)" class="text-xs text-blue-600 hover:text-blue-800 font-bold">
                    مشاهده گفتگو
                  </Link>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 pt-4 border-t border-slate-100">
            <Link :href="route('tickets.create')" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
              <Send class="w-4 h-4" />
              <span>ارسال تیکت جدید به پشتیبانی فنی</span>
            </Link>
          </div>
        </div>

      </div>

    </div>
  </AppLayout>
</template>
