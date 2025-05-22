<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    events: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const confirmDelete = (event) => {
    if (confirm(`Вы действительно хотите удалить событие #${event.id}?`)) {
        router.delete(route('admin.events.destroy', event.id), {
            preserveScroll: true,
            onSuccess: () => {
                alert('Событие было успешно удалено.');
            },
            onError: () => {
                alert('Не удалось удалить событие.');
            }
        });
    }
};
</script>

<template>
    <Head title="Управление событиями" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Управление событиями
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <div class="flex justify-end mb-6">
                        <Link :href="route('admin.events.create')">
                            <PrimaryButton>Добавить событие</PrimaryButton>
                        </Link>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700 hidden md:table-header-group">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Тип события
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Тип семьи
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Детей
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Автор
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Дата
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-300 md:table-row-group">
                            <tr v-for="event in events" :key="event.id"
                                class="md:table-row flex flex-col md:table-row mb-4 md:mb-0">
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="'ID:'">
                                    {{ event.id }}
                                </td>
                                <td class="px-6 py-4" :data-label="'Тип события:'">
                                    {{ event.event_type?.name }}
                                </td>
                                <td class="px-6 py-4" :data-label="'Тип семьи:'">
                                    {{ event.family_type?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="'Детей:'">
                                    <div class="flex flex-col">
                                        <span>Всего: {{ event.children_affected }}</span>
                                        <span>Кровных: {{ event.biological_children }}</span>
                                        <span>Приемных: {{ event.foster_children }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="'Автор:'">
                                    {{ event.user?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="'Дата:'">
                                    {{ new Date(event.created_at).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" :data-label="'Действия:'">
                                    <Link :href="route('admin.events.edit', event.id)"
                                          class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                        Редактировать
                                    </Link>
                                    <button @click="confirmDelete(event)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Удалить
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
