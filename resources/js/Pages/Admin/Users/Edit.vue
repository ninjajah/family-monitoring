<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    user: Object,
    roles: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    roles: props.user.roles.map(role => role.id),
});

const submit = () => {
    form.put(route('admin.users.update', props.user.id));
};
</script>

<template>
    <Head title="Редактировать пользователя" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Редактировать пользователя: {{ user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <InputLabel for="name" value="Имя" />
                            <TextInput id="name" v-model="form.name" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput id="email" v-model="form.email" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mb-6">
                            <h3 class="block text-sm font-medium text-gray-700 dark:text-gray-300">Роли</h3>
                            <div class="space-y-2">
                                <div v-for="role in roles" :key="role.id" class="flex items-center">
                                    <Checkbox
                                        :id="`role-${role.id}`"
                                        v-model="form.roles"
                                        :value="role.id"
                                        :checked="form.roles.includes(role.id)"
                                    />
                                    <InputLabel :for="`role-${role.id}`" :value="role.name" :classes="`ml-2`" />
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.roles" />
                        </div>

                        <div class="flex items-center justify-end">
                            <Link :href="route('admin.users.index')" class="text-gray-300 hover:text-gray-400 mr-4">Отмена</Link>
                            <PrimaryButton :disabled="form.processing">Сохранить</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
