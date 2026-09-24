<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

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
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-slate-800">
                    ثبت تیکت جدید
                </h2>
                <Link :href="route('tickets.index')" class="text-sm text-blue-600 hover:underline">
                    بازگشت به تیکت‌ها
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-700">عنوان تیکت</label>
                            <input id="title" v-model="form.title" type="text" class="block w-full mt-1 border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required />
                            <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="category" class="block text-sm font-medium text-slate-700">دسته‌بندی</label>
                                <select id="category" v-model="form.category" class="block w-full mt-1 border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="general">عمومی</option>
                                    <option value="technical">فنی</option>
                                    <option value="billing">مالی</option>
                                    <option value="order">سفارش</option>
                                </select>
                                <div v-if="form.errors.category" class="mt-1 text-sm text-red-600">{{ form.errors.category }}</div>
                            </div>

                            <div>
                                <label for="priority" class="block text-sm font-medium text-slate-700">اولویت</label>
                                <select id="priority" v-model="form.priority" class="block w-full mt-1 border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="low">کم</option>
                                    <option value="medium">متوسط</option>
                                    <option value="high">بالا</option>
                                    <option value="urgent">فوری</option>
                                </select>
                                <div v-if="form.errors.priority" class="mt-1 text-sm text-red-600">{{ form.errors.priority }}</div>
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700">پیام شما</label>
                            <textarea id="message" v-model="form.message" rows="6" class="block w-full mt-1 border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required></textarea>
                            <div v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" :disabled="form.processing" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50">
                                ارسال تیکت
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
