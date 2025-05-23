<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100">
                Детали события #{{ event?.id }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Основная информация -->
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-3">Основная информация</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Тип
                                </td>
                                <td class="p-2 text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.event_type?.name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Тип семьи
                                </td>
                                <td class="p-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.family_type?.name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Дата
                                </td>
                                <td class="p-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ formatDate(event?.created_at) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Информация о детях -->
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-3">Дети</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Всего
                                </td>
                                <td class="py-2 whitespace-nowrap text-sm text-indigo-600 dark:text-indigo-400 font-semibold">
                                    {{ event?.children_affected }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    Кровные
                                </td>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.biological_children }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    Приемные
                                </td>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.foster_children }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    Детей с ОВЗ
                                </td>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.disabled_children }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    Детей с ОВЗ 18+
                                </td>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.disabled_adults }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    Детей в семье
                                </td>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.children_in_family }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    Детей в учреждении
                                </td>
                                <td class="py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ event?.children_in_institution }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Примечания -->
            <div
                v-if="event?.notes"
                class="mt-4 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg"
            >
                <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Примечания</h4>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                    {{ event.notes }}
                </p>
            </div>

            <!-- Кнопки действий -->
            <div class="mt-6 flex justify-end space-x-3">
                <button
                    @click="$emit('close')"
                    class="px-4 py-2 text-sm rounded border border-gray-300 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                >
                    Закрыть
                </button>
                <Link
                    v-if="event?.id"
                    :href="route('admin.events.edit', event.id)"
                    class="px-4 py-2 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-700 dark:hover:bg-indigo-500 transition"
                >
                    Редактировать
                </Link>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';

defineProps({
    show: {
        type: Boolean,
        default: false
    },
    event: {
        type: Object,
        default: () => ({})
    }
});

defineEmits(['close']);

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ru-RU');
};
</script>
