<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    roles: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    roles: props.user.roles.map(role => role.id),
});

const submit = () => {
    form.put(route('admin.users.roles.update', props.user.id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-lg font-medium mb-4">Управление ролями</h3>

        <form @submit.prevent="submit">
            <div class="space-y-3 mb-6">
                <div v-for="role in roles" :key="role.id" class="flex items-center">
                    <Checkbox
                        :id="`role-${role.id}`"
                        v-model="form.roles"
                        :value="role.id"
                    />
                    <label :for="`role-${role.id}`" class="ml-2 text-sm text-gray-700">
                        {{ role.name }}
                    </label>
                </div>
                <InputError class="mt-2" :message="form.errors.roles" />
            </div>

            <PrimaryButton :disabled="form.processing">
                Обновить роли
            </PrimaryButton>
        </form>
    </div>
</template>
