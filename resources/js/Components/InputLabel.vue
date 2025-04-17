<script setup>
defineProps({
    value: {
        type: String,
    },
    classes: {
        type: String,
    }
});
</script>

<template>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" :class="classes">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
