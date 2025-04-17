<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    roles: Array,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [], // Инициализируем как пустой массив
});

// Функция для обработки изменения чекбоксов
const toggleRole = (roleId) => {
    const index = form.roles.indexOf(roleId);
    if (index === -1) {
        form.roles.push(roleId); // Добавляем роль
    } else {
        form.roles.splice(index, 1); // Удаляем роль
    }
};

const submit = () => {
    form.post(route('admin.users.store'));
};
</script>

<template>
    <Head title="Создать пользователя" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Создать нового пользователя
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <InputLabel for="name" value="Имя" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                v-model="form.email"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="password" value="Пароль" />
                            <TextInput
                                id="password"
                                type="password"
                                v-model="form.password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="password_confirmation" value="Подтверждение пароля" />
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div class="mb-6">
                            <h3 class="block text-sm font-medium text-gray-700 dark:text-gray-300">Роли</h3>
                            <div class="space-y-2">
                                <div v-for="role in roles" :key="role.id" class="flex items-center">
                                    <input
                                        type="checkbox"
                                        :id="`role-${role.id}`"
                                        :value="role.id"
                                        :checked="form.roles.includes(role.id)"
                                        @change="toggleRole(role.id)"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    />
                                    <label :for="`role-${role.id}`" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ role.name }}
                                    </label>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.roles" />
                        </div>

                        <div class="flex items-center justify-end">
                            <Link
                                :href="route('admin.users.index')"
                                class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400 mr-4"
                            >
                                Отмена
                            </Link>
                            <PrimaryButton :disabled="form.processing">
                                Создать пользователя
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
