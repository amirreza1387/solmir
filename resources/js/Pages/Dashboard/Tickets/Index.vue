<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    tickets: {
        type: Array,
        required: true
    }
});

const getPriorityColor = (priority) => {
    const colors = {
        'low': 'bg-slate-100 text-slate-800',
        'medium': 'bg-blue-100 text-blue-800',
        'high': 'bg-orange-100 text-orange-800',
        'urgent': 'bg-red-100 text-red-800'
    };
    return colors[priority] || 'bg-slate-100 text-slate-800';
};

const getPriorityLabel = (priority) => {
    const labels = {
        'low': 'کم',
        'medium': 'متوسط',
        'high': 'زیاد',
        'urgent': 'فوری'
    };
    return labels[priority] || priority;
};

const getStatusColor = (status) => {
    const colors = {
        'open': 'bg-green-100 text-green-800',
        'in_progress': 'bg-blue-100 text-blue-800',
        'answered': 'bg-purple-100 text-purple-800',
        'closed': 'bg-slate-100 text-slate-800'
    };
    return colors[status] || 'bg-slate-100 text-slate-800';
};

const getStatusLabel = (status) => {
    const labels = {
        'open': 'باز',
        'in_progress': 'در حال بررسی',
        'answered': 'پاسخ داده شده',
        'closed': 'بسته شده'
    };
    return labels[status] || status;
};

const getCategoryLabel = (category) => {
    const labels = {
        'general': 'عمومی',
        'technical': 'فنی',
        'billing': 'مالی',
        'order': 'سفارش'
    };
    return labels[category] || category;
};
</script>

<template>
    <Head title="تیکت‌های من" />

    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-slate-800">
                    تیکت‌های پشتیبانی
                </h2>
                <Link :href="route('tickets.create')" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    تیکت جدید
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-slate-900">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-right">
                                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">شماره تیکت</th>
                                        <th scope="col" class="px-6 py-3">عنوان</th>
                                        <th scope="col" class="px-6 py-3">دسته بندی</th>
                                        <th scope="col" class="px-6 py-3">اولویت</th>
                                        <th scope="col" class="px-6 py-3">وضعیت</th>
                                        <th scope="col" class="px-6 py-3">تاریخ</th>
                                        <th scope="col" class="px-6 py-3">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ticket in tickets" :key="ticket.id" class="border-b hover:bg-slate-50">
                                        <td class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap">
                                            {{ ticket.ticket_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ ticket.title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ getCategoryLabel(ticket.category) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span :class="['px-2.5 py-0.5 rounded-full text-xs font-medium', getPriorityColor(ticket.priority)]">
                                                {{ getPriorityLabel(ticket.priority) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span :class="['px-2.5 py-0.5 rounded-full text-xs font-medium', getStatusColor(ticket.status)]">
                                                {{ getStatusLabel(ticket.status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ new Date(ticket.created_at).toLocaleDateString('fa-IR') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <Link :href="route('tickets.show', ticket.id)" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                مشاهده
                                            </Link>
                                        </td>
                                    </tr>
                                    <tr v-if="tickets.length === 0">
                                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                            هیچ تیکتی یافت نشد.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
