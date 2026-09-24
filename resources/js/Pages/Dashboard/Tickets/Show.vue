<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, nextTick } from 'vue';
import { 
  MessageSquare, 
  ArrowLeft, 
  Send, 
  Clock, 
  ShieldCheck, 
  User, 
  CheckCircle2, 
  Lock 
} from 'lucide-vue-next';

const props = defineProps({
  ticket: {
    type: Object,
    required: true
  }
});

const form = useForm({
  message: ''
});

const messagesContainer = ref(null);

const submitReply = () => {
  if (!form.message.trim()) return;
  form.post(route('tickets.reply', props.ticket.id), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('message');
      scrollToBottom();
    }
  });
};

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
  });
};

onMounted(() => {
  scrollToBottom();
});

const getStatusBadge = (status) => {
  const map = {
    open: { label: 'تیکت باز', class: 'bg-emerald-100 text-emerald-800 border-emerald-200' },
    in_progress: { label: 'در حال بررسی فنی', class: 'bg-blue-100 text-blue-800 border-blue-200' },
    answered: { label: 'پاسخ پشتیبان', class: 'bg-purple-100 text-purple-800 border-purple-200' },
    closed: { label: 'بسته شده', class: 'bg-slate-100 text-slate-700 border-slate-200' }
  };
  return map[status] || { label: status, class: 'bg-slate-100 text-slate-800 border-slate-200' };
};
</script>

<template>
  <Head :title="`تیکت: ${ticket.ticket_number} | سلمیر`" />

  <AppLayout>
    <div class="max-w-4xl mx-auto space-y-6">
      
      <!-- Top Action Bar -->
      <div class="flex items-center justify-between">
        <Link 
          :href="route('tickets.index')" 
          class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-blue-600 bg-white border border-slate-200 transition"
        >
          <ArrowLeft class="w-4 h-4 rotate-180" />
          <span>بازگشت به لیست تیکت‌ها</span>
        </Link>

        <span class="text-xs font-mono font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-lg border border-blue-200/60">
          {{ ticket.ticket_number }}
        </span>
      </div>

      <!-- Ticket Metadata Card -->
      <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <div class="flex items-center gap-2 mb-1.5">
              <span 
                class="px-2.5 py-0.5 rounded-full text-xs font-bold border"
                :class="getStatusBadge(ticket.status).class"
              >
                {{ getStatusBadge(ticket.status).label }}
              </span>
              <span class="text-xs text-slate-400 font-mono">
                دسته‌بندی: {{ ticket.category || 'عمومی' }} • اولویت: {{ ticket.priority || 'متوسط' }}
              </span>
            </div>
            <h1 class="text-xl font-black text-slate-900">{{ ticket.title }}</h1>
          </div>

          <div class="text-xs text-slate-400 font-mono shrink-0">
            ایجاد: {{ new Date(ticket.created_at).toLocaleDateString('fa-IR') }}
          </div>
        </div>
      </div>

      <!-- Live Chat Messages Container -->
      <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col h-[550px]">
        
        <!-- Messages Scroll Area -->
        <div ref="messagesContainer" class="flex-1 p-6 overflow-y-auto space-y-6 bg-slate-50/70">
          <div 
            v-for="reply in ticket.replies" 
            :key="reply.id"
            class="flex items-start gap-3"
            :class="reply.is_admin ? 'flex-row' : 'flex-row-reverse'"
          >
            <!-- Avatar -->
            <div 
              class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 shadow-xs"
              :class="reply.is_admin 
                ? 'bg-gradient-to-tr from-amber-500 to-amber-600 text-white' 
                : 'bg-gradient-to-tr from-blue-600 to-indigo-600 text-white'"
            >
              <ShieldCheck v-if="reply.is_admin" class="w-4 h-4" />
              <User v-else class="w-4 h-4" />
            </div>

            <!-- Message Bubble -->
            <div 
              class="max-w-xl rounded-2xl p-4 shadow-xs text-right"
              :class="reply.is_admin 
                ? 'bg-white border border-slate-200 text-slate-800' 
                : 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-blue-500/10'"
            >
              <div class="flex items-center justify-between gap-4 mb-1.5 pb-1 border-b"
                   :class="reply.is_admin ? 'border-slate-100 text-slate-500' : 'border-white/20 text-blue-100'">
                <span class="text-xs font-bold">
                  {{ reply.is_admin ? 'پشتیبان فنی سلمیر' : reply.user?.name || 'شما' }}
                </span>
                <span class="text-[10px] font-mono opacity-80" dir="ltr">
                  {{ new Date(reply.created_at).toLocaleTimeString('fa-IR', { hour: '2-digit', minute: '2-digit' }) }}
                </span>
              </div>
              <p class="text-xs sm:text-sm whitespace-pre-wrap leading-relaxed">
                {{ reply.message }}
              </p>
            </div>
          </div>
        </div>

        <!-- Chat Input Footer -->
        <div class="p-4 bg-white border-t border-slate-200" v-if="ticket.status !== 'closed'">
          <form @submit.prevent="submitReply" class="flex gap-3">
            <textarea 
              v-model="form.message" 
              rows="2" 
              required
              @keydown.enter.prevent="submitReply"
              class="flex-1 px-4 py-3 border border-slate-300 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition resize-none bg-slate-50/50" 
              placeholder="پاسخ خود را بنویسید (Enter برای ارسال)..."
            ></textarea>
            
            <button 
              type="submit" 
              :disabled="form.processing"
              class="px-6 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-blue-500/20 hover:shadow-lg transition disabled:opacity-50 flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
            >
              <Send class="w-4 h-4" />
              <span>ارسال</span>
            </button>
          </form>
          <span v-if="form.errors.message" class="text-xs text-red-500 mt-1 block">{{ form.errors.message }}</span>
        </div>

        <div v-else class="p-4 bg-slate-100 border-t border-slate-200 text-center text-xs text-slate-500 flex items-center justify-center gap-2">
          <Lock class="w-4 h-4" />
          <span>این تیکت بسته شده است و امکان ارسال پاسخ جدید وجود ندارد.</span>
        </div>

      </div>

    </div>
  </AppLayout>
</template>
