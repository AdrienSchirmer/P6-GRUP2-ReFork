<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

interface Service {
    id: number;
    name: string;
}

const props = defineProps<{ service: Service }>();

const daysOfWeek = [
    { value: 1, label: 'Dilluns' },
    { value: 2, label: 'Dimarts' },
    { value: 3, label: 'Dimecres' },
    { value: 4, label: 'Dijous' },
    { value: 5, label: 'Divendres' },
    { value: 6, label: 'Dissabte' },
    { value: 7, label: 'Diumenge' },
];

const form = useForm({
    service_id: props.service.id,
    day_of_week: '',
    start_time: '',
    end_time: '',
});

const selectedDayLabel = computed(
    () => daysOfWeek.find((d) => d.value == form.day_of_week)?.label,
);

const isValid = computed(
    () => form.day_of_week && form.start_time && form.end_time,
);

const submit = () => {
    if (!isValid.value) {
return;
}

    form.post('/admin/service-schedules');
};
</script>

<template>
    <AppLayout>
        <Head title="Nou horari" />

        <div class="space-y-6 p-6">
            <!-- HEADER -->
            <div>
                <h1 class="text-2xl font-bold">Nou Horari</h1>
                <p class="text-sm text-gray-500">
                    Configura un horari per
                    <span class="font-medium text-gray-800">{{
                        service.name
                    }}</span>
                </p>
            </div>

            <div class="grid gap-8 lg:grid-cols-12">
                <!-- MAIN FORM -->
                <div class="lg:col-span-8">
                    <div
                        class="space-y-6 rounded-xl border bg-white p-6 shadow"
                    >
                        <!-- DAYS -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Dia de la setmana
                            </label>

                            <div class="flex flex-wrap gap-2">
                                <button
                                    v-for="day in daysOfWeek"
                                    :key="day.value"
                                    type="button"
                                    @click="form.day_of_week = day.value"
                                    :class="[
                                        'rounded-lg border px-3 py-2 text-sm transition',
                                        form.day_of_week == day.value
                                            ? 'border-blue-500 bg-blue-50 text-blue-700'
                                            : 'border-gray-200 text-gray-600 hover:bg-gray-50',
                                    ]"
                                >
                                    {{ day.label }}
                                </button>
                            </div>
                        </div>

                        <!-- TIME -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Hora inici
                                </label>
                                <input
                                    type="time"
                                    v-model="form.start_time"
                                    class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"
                                />
                            </div>

                            <div>
                                <label
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Hora fi
                                </label>
                                <input
                                    type="time"
                                    v-model="form.end_time"
                                    class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"
                                />
                            </div>
                        </div>

                        <!-- ACTIONS -->
                        <div class="flex justify-end gap-3 border-t pt-4">
                            <Link
                                :href="`/admin/services/${service.id}`"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Cancel·lar
                            </Link>

                            <button
                                @click="submit"
                                :disabled="!isValid || form.processing"
                                class="rounded-lg px-6 py-2 text-sm text-white disabled:opacity-50"
                                style="background-color: #aadbf0"
                            >
                                {{
                                    form.processing
                                        ? 'Desant...'
                                        : 'Crear horari'
                                }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SIDE PANEL -->
                <div class="lg:col-span-4">
                    <div
                        class="sticky top-6 space-y-4 rounded-xl border bg-white p-6 shadow-sm"
                    >
                        <h3 class="text-sm font-bold text-gray-900">Resum</h3>

                        <div class="space-y-2 text-sm text-gray-600">
                            <p><strong>Servei:</strong> {{ service.name }}</p>

                            <p>
                                <strong>Dia:</strong>
                                {{ selectedDayLabel || '—' }}
                            </p>

                            <p>
                                <strong>Hora:</strong>
                                {{ form.start_time || '--:--' }} →
                                {{ form.end_time || '--:--' }}
                            </p>
                        </div>

                        <div
                            v-if="isValid"
                            class="rounded-lg border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700"
                        >
                            Horari llest per guardar
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
