<template>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Тип семьи</label>
        <select
            v-model="selectedType"
            @change="handleChange"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option :value="null">Все типы</option>
            <option
                v-for="type in familyTypes"
                :key="type.id"
                :value="type.id">
                {{ type.name }}
            </option>
        </select>
    </div>
</template>

<script setup>
import {ref, watch} from 'vue';

const props = defineProps({
    modelValue: {
        type: [Number, String, null],
        default: null
    },
    familyTypes: {
        type: Array,
        required: true,
        default: () => []
    }
});

const emit = defineEmits(['update:modelValue']);

const selectedType = ref(props.modelValue);

const handleChange = () => {
    emit('update:modelValue', selectedType.value);
};

watch(() => props.modelValue, (newVal) => {
    selectedType.value = newVal;
});
</script>
