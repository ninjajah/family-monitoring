<!-- DateRangeInputs.vue -->
<template>
    <div class="mb-4 space-y-2">
        <div class="flex flex-wrap gap-2 mb-2">
            <button
                v-for="(range, name) in presets"
                :key="name"
                @click="selectPreset(range)"
                class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50"
            >
                {{ name }}
            </button>
        </div>

        <div class="flex items-center space-x-2">
            <input
                type="date"
                :value="modelValue[0]"
                @input="updateStartDate($event.target.value)"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            >
            <span>—</span>
            <input
                type="date"
                :value="modelValue[1]"
                @input="updateEndDate($event.target.value)"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            >
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    presets: {
        type: Object,
        default: () => ({})
    },
    modelValue: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['update:model-value']);

const selectPreset = (range) => {
    emit('update:model-value', range);
};

const updateStartDate = (date) => {
    emit('update:model-value', [date, props.modelValue[1]]);
};

const updateEndDate = (date) => {
    emit('update:model-value', [props.modelValue[0], date]);
};
</script>
