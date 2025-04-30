<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    signals: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const confirmDelete = (signal) => {
    if (confirm(`Вы действительно хотите удалить сигнал "${signal.name}"?`)) {
        router.delete(route('admin.signals.destroy', signal.id), {
            preserveScroll: true,
            onSuccess: () => {
                alert('Сигнал был успешно удалён.');
            },
            onError: () => {
                alert('Не удалось удалить сигнал.');
            }
        });
    }
};
</script>

<template>
    <Head title="Управление сигналами"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <div class="flex justify-end mb-6">
                        <Link :href="route('admin.signals.create')">
                            <PrimaryButton> {{ $t('Add Signal') }}</PrimaryButton>
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
                            <tr v-for="signal in signals" :key="signal.id"
                                class="md:table-row flex flex-col md:table-row mb-4 md:mb-0">
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('ID') + ':'">{{
                                        signal.id
                                    }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Name') + ':'">
                                    {{ signal.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Description') + ':'">
                                    {{ signal.description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Author') + ':'">
                                    {{ signal.user?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                    :data-label="$t('Actions') + ':'">
                                    <Link :href="route('admin.signals.edit', signal.id)"
                                          class="text-indigo-600 hover:text-indigo-900 mr-3">Редактировать
                                    </Link>
                                    <button @click="confirmDelete(signal)" class="text-red-600 hover:text-red-900">
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
