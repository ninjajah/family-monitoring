<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
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
    <Head :title="$t('Manage Events')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ $t('Manage Events') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <div class="flex justify-end mb-6">
                        <Link :href="route('admin.events.create')">
                            <PrimaryButton>{{ $t('Add Event') }}</PrimaryButton>
                        </Link>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700 hidden md:table-header-group">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $t('ID') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $t('Event Type') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $t('Family Type') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $t('Children') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $t('Author') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $t('Date') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $t('Actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-300 md:table-row-group">
                            <tr v-for="event in events" :key="event.id"
                                class="md:table-row flex flex-col md:table-row mb-4 md:mb-0">
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('ID') + ':'">
                                    {{ event.id }}
                                </td>
                                <td class="px-6 py-4" :data-label="$t('Event Type') + ':'">
                                    {{ event.event_type?.name }}
                                </td>
                                <td class="px-6 py-4" :data-label="$t('Family Type') + ':'">
                                    {{ event.family_type?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Children') + ':'">
                                    <div class="flex flex-col">
                                        <span>{{ $t('Total') }}: {{ event.children_affected }}</span>
                                        <span>{{ $t('Biological') }}: {{ event.biological_children }}</span>
                                        <span>{{ $t('Foster') }}: {{ event.foster_children }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Author') + ':'">
                                    {{ event.user?.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" :data-label="$t('Date') + ':'">
                                    {{ new Date(event.created_at).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" :data-label="$t('Actions') + ':'">
                                    <Link :href="route('admin.events.edit', event.id)"
                                          class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                        {{ $t('Edit') }}
                                    </Link>
                                    <button @click="confirmDelete(event)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        {{ $t('Delete') }}
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
