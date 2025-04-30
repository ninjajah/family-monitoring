<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    eventType: Object,
    users: Array,
});

const form = useForm({
    name: props.eventType.name,
    description: props.eventType.description,
    user_id: props.eventType.user_id,
});

const submit = () => {
    form.put(route('admin.event_types.update', props.eventType.id));
};
</script>

<template>
    <Head title="Редактировать тип события"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Редактировать: {{ eventType.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <InputLabel for="name" value="Название"/>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                class="mt-1 block w-full"
                                required/>
                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="mb-4">
                            <InputLabel for="description" value="Описание"/>
                            <TextArea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full"
                                rows="4"
                            />
                            <InputError class="mt-2" :message="form.errors.description"/>
                        </div>

                        <div class="mb-6">
                            <InputLabel for="user_id" value="Автор"/>
                            <select
                                id="user_id"
                                v-model="form.user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                required>
                                <option value="" disabled>Выберите автора</option>
                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                    :selected="user.id === eventType.user_id">
                                    {{ user.name }} ({{ user.email }})
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.user_id"/>
                        </div>

                        <div class="flex items-center justify-end">
                            <Link
                                :href="route('admin.event_types.index')"
                                class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400 mr-4">
                                Отмена
                            </Link>
                            <PrimaryButton :disabled="form.processing">
                                Сохранить
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
