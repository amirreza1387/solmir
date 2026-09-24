<template>
  <AdminLayout>
    <Head :title="ticket.title" />
    
    <div class="mb-6">
      <Link href="/admin/tickets" class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">&rarr; بازگشت به لیست</Link>
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-slate-800">{{ ticket.title }}</h1>
          <div class="text-slate-500 text-sm mt-1">
            شماره تیکت: <span class="font-mono">{{ ticket.ticket_number }}</span> | ایجاد کننده: {{ ticket.user?.name || 'کاربر' }}
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- Chat Area -->
      <div class="lg:col-span-3 flex flex-col h-[700px] bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        
        <!-- Messages -->
        <div class="flex-1 p-6 overflow-y-auto space-y-6 bg-slate-50">
          <!-- All Messages & Replies -->
          <div v-for="reply in ticket.replies" :key="reply.id" class="flex flex-col" :class="reply.is_admin ? 'items-end' : 'items-start'">
            <div class="flex items-center gap-2 mb-1">
              <span class="font-medium text-sm text-slate-600" v-if="!reply.is_admin">{{ reply.user?.name || 'کاربر' }}</span>
              <span class="font-bold text-sm text-blue-700" v-else>پشتیبانی (شما)</span>
              <span class="text-xs text-slate-500">{{ new Date(reply.created_at).toLocaleString('fa-IR') }}</span>
            </div>
            
            <div 
              class="p-4 rounded-2xl shadow-sm max-w-[85%] whitespace-pre-wrap"
              :class="reply.is_admin 
                ? 'bg-blue-600 text-white rounded-tl-sm' 
                : 'bg-white border border-slate-200 text-slate-800 rounded-tr-sm'"
            >
              {{ reply.message }}
            </div>
          </div>

          <div v-if="!ticket.replies || ticket.replies.length === 0" class="text-center py-10 text-slate-400 text-sm">
            پیامی برای این تیکت ثبت نشده است.
          </div>
        </div>

        <!-- Reply Form -->
        <div class="p-4 bg-white border-t border-slate-200">
          <form @submit.prevent="submitReply" class="flex flex-col gap-3">
            <textarea
              v-model="replyForm.message"
              rows="3"
              class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 resize-none"
              placeholder="پاسخ خود را بنویسید..."
            ></textarea>
            <div class="flex justify-between items-center">
              <span class="text-sm text-red-500">{{ replyForm.errors.message }}</span>
              <button 
                type="submit" 
                :disabled="replyForm.processing || !replyForm.message" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
              >
                ارسال پاسخ
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Ticket Settings -->
      <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
          <h2 class="font-bold text-slate-800 mb-4 pb-2 border-b">وضعیت تیکت</h2>
          
          <form @submit.prevent="updateStatus">
            <div class="space-y-4 mb-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">وضعیت</label>
                <select v-model="statusForm.status" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 text-sm">
                  <option value="open">باز</option>
                  <option value="in_progress">در حال بررسی</option>
                  <option value="answered">پاسخ داده شده</option>
                  <option value="closed">بسته شده</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">اولویت</label>
                <select v-model="statusForm.priority" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 text-sm">
                  <option value="low">کم</option>
                  <option value="medium">متوسط</option>
                  <option value="high">زیاد</option>
                  <option value="urgent">فوری</option>
                </select>
              </div>
            </div>

            <button type="submit" :disabled="statusForm.processing" class="w-full py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition text-sm font-medium">
              بروزرسانی
            </button>
          </form>
        </div>
        
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
          <h2 class="font-bold text-slate-800 mb-3 text-sm">اطلاعات کاربر</h2>
          <div class="text-sm space-y-2 text-slate-600">
            <div><span class="font-medium text-slate-800">نام:</span> {{ ticket.user?.name || 'کاربر' }}</div>
            <div><span class="font-medium text-slate-800">ایمیل:</span> {{ ticket.user?.email || '-' }}</div>
            <div v-if="ticket.user?.phone"><span class="font-medium text-slate-800">تلفن:</span> {{ ticket.user.phone }}</div>
            <div><Link href="/admin/users" class="text-blue-600 hover:underline">مشاهده در کاربران</Link></div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  ticket: Object,
});

const replyForm = useForm({
  message: '',
});

const statusForm = useForm({
  status: props.ticket.status,
  priority: props.ticket.priority,
});

const submitReply = () => {
  replyForm.post(`/admin/tickets/${props.ticket.id}/reply`, {
    preserveScroll: true,
    onSuccess: () => {
      replyForm.reset();
      if (statusForm.status === 'open') {
        statusForm.status = 'answered';
      }
    },
  });
};

const updateStatus = () => {
  statusForm.put(`/admin/tickets/${props.ticket.id}/status`, {
    preserveScroll: true,
  });
};
</script>
