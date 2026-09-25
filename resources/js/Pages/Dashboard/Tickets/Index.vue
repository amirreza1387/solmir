<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import EmptyState from '@/Components/EmptyState.vue';

defineProps({ tickets: { type: Array, required: true } });

const categoryLabel = category => ({
    general: 'عمومی', technical: 'فنی', billing: 'مالی', order: 'سفارش'
})[category] || category;
</script>

<template>
    <Head title="تیکت‌های من" />
    <AppLayout>
        <PageHeader title="تیکت‌های پشتیبانی" description="وضعیت گفتگوهای خود را پیگیری کنید.">
            <template #actions><Link :href="route('tickets.create')" class="ui-button ui-button-primary">تیکت جدید</Link></template>
        </PageHeader>

        <EmptyState v-if="tickets.length === 0" title="تیکتی ثبت نشده است" description="برای طرح پرسش یا درخواست پشتیبانی، یک تیکت ایجاد کنید.">
            <template #action><Link :href="route('tickets.create')" class="ui-button ui-button-primary">ثبت تیکت</Link></template>
        </EmptyState>
        <template v-else>
            <div class="grid gap-3 md:hidden">
                <Link v-for="ticket in tickets" :key="ticket.id" :href="route('tickets.show', ticket.id)" class="ui-card block p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs text-muted">{{ ticket.ticket_number }}</p>
                            <h2 class="mt-1 break-words font-semibold text-ink">{{ ticket.title }}</h2>
                        </div>
                        <StatusBadge :status="ticket.status" kind="ticket" />
                    </div>
                    <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-muted">
                        <span>{{ categoryLabel(ticket.category) }}</span>
                        <StatusBadge :status="ticket.priority" kind="priority" />
                        <time :datetime="ticket.created_at">{{ new Date(ticket.created_at).toLocaleDateString('fa-IR') }}</time>
                    </div>
                </Link>
            </div>
            <div class="ui-table-wrap hidden md:block">
                <table class="ui-table">
                    <thead><tr><th scope="col">شماره</th><th scope="col">عنوان</th><th scope="col">دسته‌بندی</th><th scope="col">اولویت</th><th scope="col">وضعیت</th><th scope="col">تاریخ</th><th scope="col">عملیات</th></tr></thead>
                    <tbody>
                        <tr v-for="ticket in tickets" :key="ticket.id">
                            <td class="whitespace-nowrap">{{ ticket.ticket_number }}</td>
                            <td class="max-w-72 break-words font-semibold text-ink">{{ ticket.title }}</td>
                            <td>{{ categoryLabel(ticket.category) }}</td>
                            <td><StatusBadge :status="ticket.priority" kind="priority" /></td>
                            <td><StatusBadge :status="ticket.status" kind="ticket" /></td>
                            <td class="whitespace-nowrap">{{ new Date(ticket.created_at).toLocaleDateString('fa-IR') }}</td>
                            <td><Link :href="route('tickets.show', ticket.id)" class="font-semibold text-blue-700 hover:underline">مشاهده</Link></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </AppLayout>
</template>
