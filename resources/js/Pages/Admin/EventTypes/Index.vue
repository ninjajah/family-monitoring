<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    eventTypes: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const confirmDelete = (eventType) => {
    if (confirm(`Вы действительно хотите удалить "${eventType.name}"?`)) {
        router.delete(route('admin.event_types.destroy', eventType.id), {
            preserveScroll: true,
            onSuccess: () => {
                alert('Тип события был успешно удалён.');
            },
            onError: () => {
                alert('Не удалось удалить тип события.');
            }
        });
    }
};
</script>

<template>
    <Head title="Управление типа событий"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <div class="flex justify-end mb-6">
                        <Link :href="route('admin.event_types.create')">
                            <PrimaryButton> {{ $t('Add Event Type') }}</PrimaryButton>
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
                                    Название
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Описание
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Автор
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-300 md:table-row-group">
                            <tr v-for="eventType in eventTypes" :key="eventType.id"
                                class="md:table-row flex flex-col md:table-row mb-4 md:mb-0">
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('ID') + ':'">{{
                                        eventType.id
                                    }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Name') + ':'">
                                    {{ eventType.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Description') + ':'">
                                    {{ eventType.description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Author') + ':'">
                                    {{ eventType.user?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                    :data-label="$t('Actions') + ':'">
                                    <Link :href="route('admin.event_types.edit', eventType.id)"
                                          class="text-indigo-600 hover:text-indigo-900 mr-3">Редактировать
                                    </Link>
                                    <button @click="confirmDelete(eventType)" class="text-red-600 hover:text-red-900">
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
