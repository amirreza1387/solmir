<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';

const form = useForm({
    title: '',
    category: 'general',
    priority: 'medium',
    message: ''
});

const submit = () => {
    form.post(route('tickets.store'));
};
</script>

<template>
    <Head title="تیکت جدید" />
    <AppLayout>
        <div class="mx-auto max-w-3xl space-y-6">
            <PageHeader title="ثبت تیکت جدید" description="موضوع و پیام خود را بنویسید تا از طریق پنل پاسخ داده شود.">
                <template #actions>
                    <Link :href="route('tickets.index')" class="ui-button ui-button-secondary">بازگشت به تیکت‌ها</Link>
                </template>
            </PageHeader>
            <form @submit.prevent="submit" class="ui-card space-y-6 p-5 sm:p-8">
                <div>
                    <label for="title" class="ui-label">عنوان تیکت</label>
                    <input id="title" v-model="form.title" type="text" class="ui-field mt-2" :aria-invalid="Boolean(form.errors.title)" :aria-describedby="form.errors.title ? 'title-error' : undefined" required />
                    <p v-if="form.errors.title" id="title-error" class="ui-error">{{ form.errors.title }}</p>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="category" class="ui-label">دسته‌بندی</label>
                        <select id="category" v-model="form.category" class="ui-field mt-2" :aria-invalid="Boolean(form.errors.category)">
                            <option value="general">عمومی</option>
                            <option value="technical">فنی</option>
                            <option value="billing">مالی</option>
                            <option value="order">سفارش</option>
                        </select>
                        <p v-if="form.errors.category" class="ui-error">{{ form.errors.category }}</p>
                    </div>
                    <div>
                        <label for="priority" class="ui-label">اولویت</label>
                        <select id="priority" v-model="form.priority" class="ui-field mt-2" :aria-invalid="Boolean(form.errors.priority)">
                            <option value="low">کم</option>
                            <option value="medium">متوسط</option>
                            <option value="high">بالا</option>
                            <option value="urgent">فوری</option>
                        </select>
                        <p v-if="form.errors.priority" class="ui-error">{{ form.errors.priority }}</p>
                    </div>
                </div>
                <div>
                    <label for="message" class="ui-label">پیام شما</label>
                    <textarea id="message" v-model="form.message" rows="6" class="ui-field mt-2" :aria-invalid="Boolean(form.errors.message)" :aria-describedby="form.errors.message ? 'message-error' : undefined" required></textarea>
                    <p v-if="form.errors.message" id="message-error" class="ui-error">{{ form.errors.message }}</p>
                </div>
                <div class="flex justify-end border-t border-line pt-5">
                    <button type="submit" :disabled="form.processing" class="ui-button ui-button-primary">{{ form.processing ? 'در حال ارسال...' : 'ارسال تیکت' }}</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
