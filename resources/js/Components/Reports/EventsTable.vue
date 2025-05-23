<template>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Дата
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Тип события
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Тип семьи
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Всего детей
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Детали
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="event in events" :key="event.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ formatDate(event.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.event_type?.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ event.family_type?.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.children_affected }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <button
                        @click="showDetails(event)"
                        class="text-indigo-600 hover:text-indigo-900"
                    >
                        Подробнее
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import {defineEmits} from 'vue';

const props = defineProps({
    events: {
        type: Array,
        required: true,
        default: () => []
    }
});

const emit = defineEmits(['showDetails']);

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ru-RU');
};

const showDetails = (event) => {
    emit('showDetails', event);
};
</script>
