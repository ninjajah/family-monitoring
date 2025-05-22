<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateEventForm from '@/Components/Events/CreateForm.vue';

const props = defineProps({
    eventTypes: Array,
    familyTypes: Array,
    users: Array,
});

</script>

<template>
    <Head title="Добавить событие" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Добавить событие
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <CreateEventForm
                        :event-types="eventTypes"
                        :family-types="familyTypes"
                        :users="users"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
