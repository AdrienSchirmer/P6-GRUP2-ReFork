<script setup lang="ts">
import { computed } from 'vue';
import { Form, Head, router, usePage } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import {
    destroy as pharmaciesDestroy,
    index as pharmaciesIndex,
    store as pharmaciesStore,
} from '@/routes/pharmacies';
import { type BreadcrumbItem } from '@/types';

interface Pharmacy {
    id: number;
    name: string;
    latitude: number;
    longitude: number;
    created_at?: string | null;
}

const props = defineProps<{
    pharmacies: Pharmacy[];
}>();

const page = usePage<{ flash?: { message?: string } }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Farmàcies', href: pharmaciesIndex().url },
];

const removePharmacy = (pharmacyId: number) => {
    router.delete(pharmaciesDestroy(pharmacyId).url, {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Farmàcies" />

        <div
            class="relative flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4 md:p-6"
        >
            <div
                class="pointer-events-none absolute top-0 right-8 h-48 w-48 rounded-full bg-muted/70 blur-3xl"
            ></div>
            <div
                class="pointer-events-none absolute bottom-0 left-0 h-56 w-56 rounded-full bg-secondary/60 blur-3xl"
            ></div>

            <div
                class="relative rounded-2xl border border-sidebar-border/70 bg-gradient-to-br from-background to-muted/70 p-7 shadow-sm"
            >
                <p
                    class="text-xs font-semibold tracking-[0.18em] text-muted-foreground uppercase"
                >
                    Farmacia Soler
                </p>
                <h1
                    class="mt-2 text-3xl font-semibold tracking-tight text-foreground"
                >
                    Farmàcies
                </h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Gestió bàsica de farmàcies: crear i eliminar.
                </p>
            </div>

            <div
                v-if="page.props.flash?.message"
                class="rounded-xl border border-green-200 bg-green-50/90 px-4 py-3 text-sm text-green-700 shadow-sm"
                role="alert"
            >
                {{ page.props.flash?.message }}
            </div>

            <div
                class="relative rounded-2xl border border-sidebar-border/70 bg-background/95 p-6 shadow-sm"
            >
                <Form
                    v-bind="pharmaciesStore.form()"
                    :reset-on-success="['name', 'latitude', 'longitude']"
                    v-slot="{ errors, processing }"
                    class="grid gap-5"
                >
                    <div class="grid gap-2">
                        <Label for="name">Nom</Label>
                        <Input
                            id="name"
                            type="text"
                            name="name"
                            required
                            autofocus
                            placeholder="Nom de la farmàcia"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="latitude">Latitud</Label>
                        <Input
                            id="latitude"
                            type="number"
                            step="0.0000001"
                            name="latitude"
                            required
                            placeholder="42.2655337"
                        />
                        <InputError :message="errors.latitude" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="longitude">Longitud</Label>
                        <Input
                            id="longitude"
                            type="number"
                            step="0.0000001"
                            name="longitude"
                            required
                            placeholder="2.9631538"
                        />
                        <InputError :message="errors.longitude" />
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-3">
                        <Button
                            type="submit"
                            :disabled="processing"
                            class="bg-primary text-primary-foreground hover:bg-primary/90"
                        >
                            {{ processing ? 'Creant...' : 'Crear farmàcia' }}
                        </Button>
                    </div>
                </Form>
            </div>

            <div
                class="relative rounded-2xl border border-sidebar-border/70 bg-background/95 p-5 shadow-sm"
            >
                <h2 class="text-lg font-semibold text-foreground">
                    Farmàcies registrades
                </h2>

                <div class="mt-4 overflow-x-auto">
                    <table
                        class="min-w-full divide-y divide-sidebar-border/70 text-sm"
                    >
                        <thead class="bg-muted/40">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Nom
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Latitud
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Longitud
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Accions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sidebar-border/70">
                            <tr
                                v-for="pharmacy in props.pharmacies"
                                :key="pharmacy.id"
                                class="transition-colors hover:bg-muted/30"
                            >
                                <td class="px-4 py-3 font-medium">
                                    {{ pharmacy.name }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ pharmacy.latitude }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ pharmacy.longitude }}
                                </td>
                                <td class="px-4 py-3">
                                    <button
                                        type="button"
                                        class="cursor-pointer rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                        @click="removePharmacy(pharmacy.id)"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="props.pharmacies.length === 0">
                                <td
                                    colspan="4"
                                    class="px-4 py-8 text-center text-muted-foreground"
                                >
                                    Encara no hi ha farmàcies.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
