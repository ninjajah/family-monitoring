<template>
    <div v-if="stats" class="mb-6 bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-medium mb-3">Статистика на {{ formatDate(date) }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <StatCard
                title="Семей на сопровождении"
                :value="stats.families_count"
                icon="users"
                variant="primary"
            />
            <StatCard
                title="Детей на сопровождении"
                :value="stats.children_count"
                icon="child"
                variant="primary"
            />
        </div>

        <h4 class="font-medium mb-2">По типам семей:</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                v-for="[typeId, data] in Object.entries(stats.by_family_type || {})"
                :key="typeId"
                class="bg-white p-3 rounded shadow"
            >
                <h5 class="font-medium text-indigo-600">
                    {{ getFamilyTypeName(typeId) }}
                </h5>
                <div class="flex justify-between mt-2">
                    <span>Семей:</span>
                    <span class="font-medium">{{ data.count }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Детей:</span>
                    <span class="font-medium">{{ data.children }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import StatCard from "@/Components/Reports/StatCard.vue";

const props = defineProps({
    stats: {
        type: Object,
        default: null
    },
    date: {
        type: String,
        required: true
    },
    familyTypes: {
        type: Array,
        required: true,
        default: () => []
    }
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ru-RU');
};

const getFamilyTypeName = (typeId) => {
    return props.familyTypes.find(t => t.id == typeId)?.name || `Тип ${typeId}`;
};
</script>
