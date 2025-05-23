<!-- DateInput.vue -->
<template>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Дата</label>
        <input
            type="date"
            :value="modelValue"
            @input="$emit('update:model-value', $event.target.value)"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
    </div>
</template>

<script setup>
defineProps({
    modelValue: {
        type: String,
        required: true
    }
});

defineEmits(['update:model-value']);
</script>
