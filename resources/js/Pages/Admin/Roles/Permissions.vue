<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
    permissions: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    permissions: props.role.permissions.map(p => p.id),
});

const submit = () => {
    form.put(route('admin.roles.permissions.update', props.role.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-lg font-medium mb-4">Управление разрешениями для роли: {{ role.name }}</h3>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div v-for="permission in permissions" :key="permission.id" class="flex items-center">
                    <Checkbox
                        :id="`perm-${permission.id}`"
                        v-model="form.permissions"
                        :value="permission.id"
                    />
                    <label :for="`perm-${permission.id}`" class="ml-2 text-sm text-gray-700">
                        {{ permission.name }}
                    </label>
                </div>
            </div>
            <InputError class="mt-2" :message="form.errors.permissions" />

            <div class="flex justify-end">
                <PrimaryButton :disabled="form.processing">
                    Сохранить разрешения
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
