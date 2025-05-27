<template>
    <Head title="Отчеты"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Отчеты
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <div class="space-y-6">
                        <!-- Отчет по новым семьям -->
                        <ReportCard title="Семей пришло на сопровождение">
                            <div class="flex flex-wrap items-end gap-4 mb-4">
                                <DateRangeInputs
                                    :presets="datePresets"
                                    :model-value="[filters.start_date, filters.end_date]"
                                    @update:model-value="handleDateRangeChange"
                                    class="flex-col"
                                />
                                <FamilyTypeFilter
                                    v-model="filters.family_type_id"
                                    :family-types="familyTypes"
                                    @update:model-value="handleDateRangeChange([filters.start_date, filters.end_date])"
                                    class="flex-col"
                                />
                            </div>
                            <ReportStats v-if="newChildren" :stats="newChildren.stats"/>
                            <EventsTable
                                v-if="newChildren"
                                :events="newChildren.events"
                            />
                        </ReportCard>

                        <!-- Текущее сопровождение -->
                        <ReportCard title="Семьи на сопровождении">
                            <div class="flex flex-wrap items-end gap-4 mb-4">
                                <DateInput
                                    v-model="filters.date"
                                    @update:model-value="handleDateChange"
                                    class="flex-col"
                                />
                                <FamilyTypeFilter
                                    v-model="filters.family_type_id"
                                    :family-types="familyTypes"
                                    @update:model-value="handleDateChange(filters.date)"
                                    class="flex-col"
                                />
                            </div>
                            <CurrentStatusStats
                                v-if="currentStatus"
                                :stats="currentStatus.stats"
                                :date="filters.date"
                                :family-types="familyTypes"
                            />
                            <EventsTable
                                v-if="currentStatus"
                                :events="currentStatus.events"
                            />
                        </ReportCard>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {computed} from 'vue';
import {Head, router} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ReportCard from "@/Components/Reports/ReportCard.vue";
import DateRangeInputs from "@/Components/Reports/DateRangeInputs.vue";
import FamilyTypeFilter from "@/Components/Reports/FamilyTypeFilter.vue";
import ReportStats from "@/Components/Reports/ReportStats.vue";
import EventsTable from "@/Components/Reports/EventsTable.vue";
import DateInput from "@/Components/Reports/DateInput.vue";
import CurrentStatusStats from "@/Components/Reports/CurrentStatusStats.vue";

const props = defineProps({
    newChildren: Object,
    currentStatus: Object,
    familyTypes: Array,
    filters: Object
});

const datePresets = computed(() => {
    const today = new Date().toISOString().split('T')[0];
    const startOfWeek = new Date();
    startOfWeek.setDate(startOfWeek.getDate() - startOfWeek.getDay());
    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6);

    const startOfMonth = new Date();
    startOfMonth.setDate(1);
    const endOfMonth = new Date(
        startOfMonth.getFullYear(),
        startOfMonth.getMonth() + 1,
        0
    );

    return {
        'Сегодня': [today, today],
        'Неделя': [
            startOfWeek.toISOString().split('T')[0],
            endOfWeek.toISOString().split('T')[0]
        ],
        'Месяц': [
            startOfMonth.toISOString().split('T')[0],
            endOfMonth.toISOString().split('T')[0]
        ]
    };
});

const filters = computed(() => ({
    start_date: props.filters?.start_date || new Date().toISOString().split('T')[0],
    end_date: props.filters?.end_date || new Date().toISOString().split('T')[0],
    date: props.filters?.date || new Date().toISOString().split('T')[0],
    family_type_id: props.filters?.family_type_id || null
}));

const handleDateRangeChange = ([start, end]) => {
    router.get(route('admin.reports.new-children'), {
        start_date: start,
        end_date: end,
        family_type_id: filters.value.family_type_id // убедитесь, что передается текущее значение
    }, {
        preserveState: true,
        replace: true
    });
};

const handleDateChange = (date) => {
    router.get(route('admin.reports.current'), {
        date: date,
        family_type_id: filters.value.family_type_id // убедитесь, что передается текущее значение
    }, {
        preserveState: true,
        replace: true
    });
};
</script>
