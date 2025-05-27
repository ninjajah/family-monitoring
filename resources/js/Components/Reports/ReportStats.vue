<template>
    <div v-if="stats" class="mb-6 bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-medium mb-3">Сводная статистика</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <StatCard
                title="Всего семей"
                :value="stats.families_count"
                icon="users"
            />
            <StatCard
                title="Всего детей"
                :value="stats.children_count"
                icon="child"
            />
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <StatCard
                title="Кровные дети"
                :value="stats.biological_children"
                icon="dna"
            />
            <StatCard
                title="Приемные дети"
                :value="stats.foster_children"
                icon="heart"
            />
            <StatCard
                title="Дети с инвалидностью"
                :value="stats.disabled_children"
                icon="wheelchair"
            />
            <StatCard
                title="В семьях"
                :value="stats.in_family"
                icon="home"
            />
            <StatCard
                title="В учреждениях"
                :value="stats.in_institution"
                icon="building"
            />
        </div>
    </div>
</template>

<script setup>

import StatCard from "@/Components/Reports/StatCard.vue";

defineProps({
    stats: {
        type: Object,
        default: null
    }
});
</script>
