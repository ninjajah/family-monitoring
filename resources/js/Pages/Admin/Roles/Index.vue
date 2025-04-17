<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    roles: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Управление ролями" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Управление ролями
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <div class="flex justify-end mb-6">
                        <Link :href="route('admin.roles.create')">
                            <PrimaryButton> Создать роль </PrimaryButton>
                        </Link>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Название</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Разрешения</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="role in roles" :key="role.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ role.id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ role.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        v-for="permission in role.permissions"
                                        :key="permission.id"
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mr-1 mb-1"
                                    >
                                        {{ permission.name }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <Link
                                    :href="route('admin.roles.edit', role.id)"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3"
                                >
                                    Редактировать
                                </Link>
                                <Link
                                    :href="route('admin.roles.destroy', role.id)"
                                    method="delete"
                                    as="button"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Удалить
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
