<template>
  <AdminLayout>
    <Head title="مدیریت کاربران" />
    
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-slate-800">کاربران</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-right">
          <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
              <th class="p-4 font-medium">نام</th>
              <th class="p-4 font-medium">ایمیل / موبایل</th>
              <th class="p-4 font-medium">نقش</th>
              <th class="p-4 font-medium">تاریخ عضویت</th>
              <th class="p-4 font-medium">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id" class="border-b border-slate-100 hover:bg-slate-50">
              <td class="p-4">{{ user.name }}</td>
              <td class="p-4">
                <div class="text-sm">{{ user.email }}</div>
                <div class="text-xs text-slate-500" v-if="user.phone">{{ user.phone }}</div>
              </td>
              <td class="p-4">
                <select
                  v-model="user.role"
                  @change="updateRole(user)"
                  class="text-sm border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="user">کاربر عادی</option>
                  <option value="admin">مدیر</option>
                </select>
              </td>
              <td class="p-4 text-slate-600">{{ new Date(user.created_at).toLocaleDateString('fa-IR') }}</td>
              <td class="p-4">
                <button @click="deleteUser(user)" class="text-red-500 hover:text-red-700 text-sm">
                  حذف
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <div class="p-4 border-t border-slate-200 flex justify-center gap-1" v-if="users.links && users.links.length > 3">
        <template v-for="(link, i) in users.links" :key="i">
          <Link
            v-if="link.url"
            :href="link.url"
            class="px-3 py-1 border rounded text-sm"
            :class="link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-300 hover:bg-slate-50'"
            v-html="link.label"
          />
          <span v-else class="px-3 py-1 border rounded text-sm bg-slate-50 text-slate-400 border-slate-200" v-html="link.label"></span>
        </template>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  users: Object,
});

const updateRole = (user) => {
  router.put(`/admin/users/${user.id}`, {
    role: user.role,
  }, {
    preserveScroll: true,
  });
};

const deleteUser = (user) => {
  if (confirm('آیا از حذف این کاربر اطمینان دارید؟')) {
    router.delete(`/admin/users/${user.id}`);
  }
};
</script>
