<template>
    <div class="bg-white p-4 rounded shadow">
        <div class="flex items-center">
            <div class="p-2 rounded-full" :class="iconBgClass">
                <Icon :name="icon" class="h-5 w-5" :class="iconColorClass"/>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 truncate">
                    {{ title }}
                </p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ value || 0 }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>

import Icon from "@/Components/Reports/Icon.vue";
import {computed} from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: [Number, String],
        default: 0
    },
    icon: {
        type: String,
        required: true
    },
    variant: {
        type: String,
        default: 'default',
        validator: (value) => ['default', 'primary'].includes(value)
    }
});

const iconBgClass = computed(() => ({
    'bg-indigo-100': props.variant === 'default',
    'bg-indigo-200': props.variant === 'primary'
}));

const iconColorClass = computed(() => ({
    'text-indigo-600': props.variant === 'default',
    'text-indigo-800': props.variant === 'primary'
}));
</script>
