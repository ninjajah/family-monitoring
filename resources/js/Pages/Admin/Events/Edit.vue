<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    event: Object,
    eventTypes: Array,
    familyTypes: Array,
    users: Array,
});

const form = useForm({
    event_type_id: props.event.event_type_id,
    family_type_id: props.event.family_type_id,
    children_affected: props.event.children_affected,
    biological_children: props.event.biological_children,
    foster_children: props.event.foster_children,
    disabled_children: props.event.disabled_children,
    disabled_adults: props.event.disabled_adults,
    children_in_family: props.event.children_in_family,
    children_in_institution: props.event.children_in_institution,
    notes: props.event.notes,
    user_id: props.event.user_id,
});

const submit = () => {
    form.put(route('admin.events.update', props.event.id));
};
</script>

<template>
    <Head :title="$t('Update Event')"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ $t('Update Event')}} #{{ event.id }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <InputLabel for="event_type_id" value="Тип события"/>
                            <select
                                id="event_type_id"
                                v-model="form.event_type_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                required>
                                <option value="" disabled>Выберите тип события</option>
                                <option
                                    v-for="eventType in eventTypes"
                                    :key="eventType.id"
                                    :value="eventType.id"
                                    :selected="eventType.id === event.event_type_id">
                                    {{ eventType.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.event_type_id"/>
                        </div>
                        <div class="mb-4">
                            <InputLabel for="family_type_id" value="Тип семьи"/>
                            <select
                                id="family_type_id"
                                v-model="form.family_type_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                required>
                                <option value="" disabled>Выберите тип семьи</option>
                                <option
                                    v-for="familyType in familyTypes"
                                    :key="familyType.id"
                                    :value="familyType.id"
                                    :selected="familyType.id === event.family_type_id">
                                    {{ familyType.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.family_type_id"/>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <InputLabel for="biological_children" value="Кровных детей"/>
                                <TextInput
                                    id="biological_children"
                                    v-model="form.biological_children"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                    required/>
                                <InputError class="mt-2" :message="form.errors.biological_children"/>
                            </div>
                            <div>
                                <InputLabel for="foster_children" value="Приемных детей"/>
                                <TextInput
                                    id="foster_children"
                                    v-model="form.foster_children"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                    required/>
                                <InputError class="mt-2" :message="form.errors.foster_children"/>
                            </div>
                            <div>
                                <InputLabel for="disabled_children" value="Детей с ОВЗ"/>
                                <TextInput
                                    id="disabled_children"
                                    v-model="form.disabled_children"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                    required/>
                                <InputError class="mt-2" :message="form.errors.disabled_children"/>
                            </div>
                            <div>
                                <InputLabel for="disabled_adults" value="Детей с ОВЗ 18+"/>
                                <TextInput
                                    id="disabled_adults"
                                    v-model="form.disabled_adults"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                    required/>
                                <InputError class="mt-2" :message="form.errors.disabled_adults"/>
                            </div>
                            <div>
                                <InputLabel for="children_in_family" value="Детей в семье"/>
                                <TextInput
                                    id="children_in_family"
                                    v-model="form.children_in_family"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                    required/>
                                <InputError class="mt-2" :message="form.errors.children_in_family"/>
                            </div>
                            <div>
                                <InputLabel for="children_in_institution" value="Детей в учреждении"/>
                                <TextInput
                                    id="children_in_institution"
                                    v-model="form.children_in_institution"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                    required/>
                                <InputError class="mt-2" :message="form.errors.children_in_institution"/>
                            </div>
                        </div>
                        <div class="mb-4">
                            <InputLabel for="notes" value="Примечания"/>
                            <TextArea
                                id="notes"
                                v-model="form.notes"
                                class="mt-1 block w-full"
                                rows="4"/>
                            <InputError class="mt-2" :message="form.errors.notes"/>
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
                                    :selected="user.id === event.user_id">
                                    {{ user.name }} ({{ user.email }})
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.user_id"/>
                        </div>
                        <div class="flex items-center justify-end">
                            <Link
                                :href="route('admin.events.index')"
                                class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400 mr-4">
                                {{ $t('Cancel') }}
                            </Link>
                            <PrimaryButton :disabled="form.processing">
                                {{ $t('Save') }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
