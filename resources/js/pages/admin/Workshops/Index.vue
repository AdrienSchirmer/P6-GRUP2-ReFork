<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import type { BreadcrumbItem } from '@/types';
import {
    create as workshopsCreate,
    destroy as workshopsDestroy,
    edit as workshopsEdit,
    index as workshopsIndex,
} from '@/routes/workshops';

const workshopToDelete = ref<number | null>(null);

function deleteWorkshop(id: number) {
    workshopToDelete.value = id;
}

function confirmDelete() {
    if (workshopToDelete.value === null) {
        return;
    }

    useForm({}).delete(workshopsDestroy(workshopToDelete.value).url);
    workshopToDelete.value = null;
}

function cancelDelete() {
    workshopToDelete.value = null;
}

type Workshop = {
    id: number;
    name: string;
    description: string;
    photo_path: string | null;
    workshop_date: string;
    start_time: string;
    end_time: string;
    max_attendees: number | null;
    is_active: boolean;
};

const props = defineProps<{
    workshops: Workshop[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tallers', href: workshopsIndex().url },
];

const searchQuery = ref('');

const filteredWorkshops = computed(() => {
    const query = searchQuery.value.trim().toLowerCase();

    if (!query) {
        return props.workshops;
    }

    return props.workshops.filter((workshop) => {
        return (
            workshop.name.toLowerCase().includes(query) ||
            workshop.description.toLowerCase().includes(query)
        );
    });
});

const formatTime = (time: string) => time.slice(0, 5);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Tallers" />

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
                    Tallers
                </h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Gestió inicial dels tallers programats de la farmàcia.
                </p>
            </div>

            <div
                class="relative rounded-2xl border border-sidebar-border/70 bg-background/95 p-5 shadow-sm"
            >
                <div
                    class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center"
                >
                    <input
                        v-model="searchQuery"
                        type="search"
                        placeholder="Cerca per nom o descripció"
                        class="w-full rounded-xl border border-sidebar-border/80 bg-background px-3 py-2 text-sm shadow-xs transition focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/30 focus-visible:outline-none"
                    />

                    <Link
                        :href="workshopsCreate().url"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition hover:bg-primary/90 sm:ml-auto sm:w-auto"
                    >
                        <Plus class="mr-2 h-4 w-4" />
                        Crear taller
                    </Link>
                </div>

                <div class="overflow-x-auto">
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
                                    Data
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Horari
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Places
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Estat
                                </th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sidebar-border/70">
                            <tr
                                v-for="workshop in filteredWorkshops"
                                :key="workshop.id"
                                class="transition-colors hover:bg-muted/30"
                            >
                                <td class="px-4 py-3">
                                    <div class="font-medium">
                                        {{ workshop.name }}
                                    </div>
                                    <div
                                        class="mt-1 text-xs text-muted-foreground"
                                        v-html="workshop.description"
                                    >
                                       
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{
                                        new Date(
                                            workshop.workshop_date,
                                        ).toLocaleDateString('ca-ES')
                                    }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ formatTime(workshop.start_time) }} -
                                    {{ formatTime(workshop.end_time) }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{
                                        workshop.max_attendees ?? 'Sense límit'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    <span
                                        class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                        :class="
                                            workshop.is_active
                                                ? 'border-green-200 bg-green-50 text-green-700'
                                                : 'border-zinc-200 bg-zinc-100 text-zinc-600'
                                        "
                                    >
                                        {{
                                            workshop.is_active
                                                ? 'Actiu'
                                                : 'Inactiu'
                                        }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <Link
                                            :href="
                                                workshopsEdit(workshop.id).url
                                            "
                                            class="inline-flex items-center rounded-lg p-1.5 text-muted-foreground transition hover:bg-muted hover:text-foreground"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Link>
                                        <button
                                            type="button"
                                            class="inline-flex cursor-pointer items-center rounded-lg p-1.5 text-muted-foreground transition hover:bg-red-50 hover:text-red-600"
                                            @click="deleteWorkshop(workshop.id)"
                                        >
                                            <Trash2
                                                class="h-4 w-4 cursor-pointer"
                                            />
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="filteredWorkshops.length === 0">
                                <td
                                    colspan="5"
                                    class="px-4 py-8 text-center text-muted-foreground"
                                >
                                    Encara no hi ha tallers registrats.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Dialog :open="workshopToDelete !== null" @update:open="cancelDelete">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Eliminar taller</DialogTitle>
                    <DialogDescription>
                        Segur que vols eliminar aquest taller? Aquesta acció no
                        es pot desfer.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <button
                        type="button"
                        class="inline-flex cursor-pointer items-center rounded-xl border border-sidebar-border/80 bg-background px-4 py-2 text-sm font-medium transition hover:bg-muted"
                        @click="cancelDelete"
                    >
                        Cancel·lar
                    </button>
                    <button
                        type="button"
                        class="inline-flex cursor-pointer items-center rounded-xl bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700"
                        @click="confirmDelete"
                    >
                        Eliminar
                    </button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
