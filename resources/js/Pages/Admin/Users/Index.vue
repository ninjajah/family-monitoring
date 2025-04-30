<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    users: {
        type: Array,
        required: true,
        default: () => [],
    },
});
const confirmDelete = (user) => {
    if (confirm(`Вы действительно хотите удалить пользователя ${user.name}?`)) {
        router.delete(route('admin.users.destroy', user.id), {
            preserveScroll: true,
            onSuccess: () => {
                alert('Пользователь был успешно удалён.');
            },
            onError: () => {
                alert('Не удалось удалить пользователя.');
            }
        });
    }
};
</script>

<template>
    <Head title="Управление пользователями"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Управление пользователями
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <div class="flex justify-end mb-6">
                        <Link :href="route('admin.users.create')">
                            <PrimaryButton> Создать пользователя</PrimaryButton>
                        </Link>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700 hidden md:table-header-group">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Имя
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Роли
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-300 md:table-row-group">
                            <tr v-for="user in users" :key="user.id"
                                class="md:table-row flex flex-col md:table-row mb-4 md:mb-0">
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('ID') + ':'">{{ user.id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Name') + ':'">{{ user.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Email') + ':'">{{ user.email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Roles') + ':'">
                                    <span v-for="role in user.roles" :key="role.id"
                                          class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mr-1">
                                        {{ role.name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" :data-label="$t('Actions') + ':'">
                                    <Link :href="route('admin.users.edit', user.id)"
                                          class="text-indigo-600 hover:text-indigo-900 mr-3">Редактировать
                                    </Link>
                                    <button @click="confirmDelete(user)" class="text-red-600 hover:text-red-900">Удалить
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
