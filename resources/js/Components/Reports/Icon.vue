<template>
    <component
        :is="iconComponent"
        :class="computedClass"
        aria-hidden="true"
    />
</template>

<script setup>
import {computed} from 'vue';
import {
    UsersIcon as Users,
    UserIcon as Child,
    QueueListIcon as Dna,
    HeartIcon as Heart,
    LifebuoyIcon as Wheelchair,
    HomeIcon as Home,
    BuildingOfficeIcon as Building,
    CalendarIcon as Calendar,
    ChartBarIcon as ChartBar
} from '@heroicons/vue/24/outline';

const props = defineProps({
    name: {
        type: String,
        required: true,
        validator: (value) => [
            'users', 'child', 'dna', 'heart', 'wheelchair',
            'home', 'building', 'calendar', 'chart-bar'
        ].includes(value)
    },
    class: {
        type: [String, Array, Object],
        default: ''
    }
});

const iconMap = {
    'users': Users,
    'child': Child,
    'dna': Dna,
    'heart': Heart,
    'wheelchair': Wheelchair,
    'home': Home,
    'building': Building,
    'calendar': Calendar,
    'chart-bar': ChartBar
};

const iconComponent = computed(() => iconMap[props.name] || Users);
const computedClass = computed(() => ['h-5 w-5', props.class]);
</script>
