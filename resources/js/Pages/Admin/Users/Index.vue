<template>
  <AdminLayout>
    <Head title="مدیریت کاربران" />

    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">کاربران</h1>
        <p class="text-xs text-slate-500 mt-1">مدیریت حساب‌ها، نقش‌ها و دسترسی کاربران سامانه</p>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium text-xs">نام</th>
              <th class="p-4 font-medium text-xs">ایمیل / موبایل</th>
              <th class="p-4 font-medium text-xs">نقش</th>
              <th class="p-4 font-medium text-xs">تاریخ عضویت</th>
              <th class="p-4 font-medium text-xs text-center">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id" class="border-b border-slate-100 hover:bg-slate-50/70 transition">
              <td class="p-4 font-medium text-slate-900 text-sm">{{ user.name }}</td>
              <td class="p-4">
                <div class="text-sm text-slate-700 font-mono">{{ user.email }}</div>
                <div class="text-xs text-slate-400 font-mono mt-0.5" v-if="user.phone">{{ user.phone }}</div>
              </td>
              <td class="p-4">
                <select
                  v-model="user.role"
                  :disabled="updatingUserId === user.id"
                  @change="updateRole(user)"
                  class="text-xs border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1.5 px-2.5 bg-white disabled:opacity-50"
                >
                  <option value="user">کاربر عادی</option>
                  <option value="admin">مدیر سیستم</option>
                </select>
              </td>
              <td class="p-4 text-xs text-slate-500 font-mono">{{ new Date(user.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4 text-center">
                <button
                  type="button"
                  @click="promptDeleteUser(user)"
                  class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1 rounded hover:bg-red-50 transition cursor-pointer"
                >
                  حذف
                </button>
              </td>
            </tr>
            <tr v-if="users.data.length === 0">
              <td colspan="5" class="p-12 text-center text-slate-400 text-sm">
                هیچ کاربری یافت نشد.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Persian Pagination -->
      <Pagination
        :links="users.links || []"
        :from="users.from"
        :to="users.to"
        :total="users.total"
      />
    </div>

    <!-- Confirmation Modal for Deletion -->
    <ConfirmModal
      :show="showDeleteModal"
      title="حذف حساب کاربر"
      :message="`آیا از حذف حساب کاربری '${selectedUser?.name}' اطمینان دارید؟ این عملیات کاربر را به سطل بازیافت منتقل می‌کند.`"
      confirm-text="بله، حذف شود"
      cancel-text="انصراف"
      :loading="isDeleting"
      @confirm="confirmDeleteUser"
      @close="showDeleteModal = false"
    />
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';

const props = defineProps({
  users: Object,
});

const showDeleteModal = ref(false);
const selectedUser = ref(null);
const isDeleting = ref(false);
const updatingUserId = ref(null);

const updateRole = (user) => {
  updatingUserId.value = user.id;
  router.put(`/admin/users/${user.id}`, {
    role: user.role,
  }, {
    preserveScroll: true,
    onFinish: () => {
      updatingUserId.value = null;
    },
  });
};

const promptDeleteUser = (user) => {
  selectedUser.value = user;
  showDeleteModal.value = true;
};

const confirmDeleteUser = () => {
  if (!selectedUser.value || isDeleting.value) return;
  isDeleting.value = true;
  router.delete(`/admin/users/${selectedUser.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false;
      selectedUser.value = null;
    },
    onFinish: () => {
      isDeleting.value = false;
    },
  });
};
</script>
