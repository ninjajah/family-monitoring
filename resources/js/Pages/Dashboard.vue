<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import CreateEventForm from '@/Components/Events/CreateForm.vue';

const props = defineProps({
    eventTypes: Array,
    familyTypes: Array,
    users: Array,
});
</script>

<template>
    <Head :title="$t('Dashboard')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ $t('Dashboard') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <CreateEventForm
                            :event-types="eventTypes"
                            :family-types="familyTypes"
                            :users="users"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
