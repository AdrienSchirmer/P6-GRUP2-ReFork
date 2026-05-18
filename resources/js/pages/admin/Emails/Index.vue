<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Trash2 } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Administració dels Correus', href: 'admin/emails' },
];

const props = defineProps<{
    emails?: {
        id: number;
        email: string;
        active: number;
    }[];
}>();

const displayedEmails = ref(props.emails ?? []);
const search = ref('');
const fetchedEmails = ref(props.emails ?? []);

watch(
    () => props.emails,
    (newEmails) => {
        fetchedEmails.value = newEmails ?? [];
        doSearch();
    },
);

function normalize(str: string) {
    return str
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase();
}

function doSearch() {
    const s = normalize(search.value);
    displayedEmails.value = fetchedEmails.value.filter((email) =>
        normalize(email.email).includes(s),
    );
}

const handleFilterChange = async (event: Event) => {
    const filter = (event.target as HTMLSelectElement).value;
    const url =
        {
            Tot: '/admin/emails',
            Actiu: '/admin/emails?filter=active',
            Inactiu: '/admin/emails?filter=inactive',
        }[filter] ?? '/admin/emails';
    const response = await fetch(url, {
        headers: { Accept: 'application/json' },
    });
    displayedEmails.value = await response.json();
};

const selectedEmailIds = ref<number[]>(
    props.emails
        ?.filter((email) => email.active === 1)
        .map((email) => email.id) ?? [],
);

const form = useForm({
    active: 0,
});

const handleChange = (emailId: number) => {
    const isActive = selectedEmailIds.value.includes(emailId);
    form.active = isActive ? 1 : 0;
    form.patch(`/admin/emails/${emailId}`, { preserveScroll: true });
};
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-3 sm:p-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"
            >
                <div>
                    <h1 class="mb-2 text-2xl font-semibold">
                        Configuració Correus
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Configura a on s'enviarà el correu de part admin, quan
                        un usuari crea un encàrrec o un reserva.
                    </p>
                    <p class="text-sm text-muted-foreground">
                        Correus actius: {{ selectedEmailIds.length }}/3
                    </p>
                </div>
                <Link
                    href="/admin/emails/create"
                    class="rounded-md bg-blue-600 px-4 py-2 text-lg font-medium text-white hover:bg-blue-700"
                >
                    Crear
                </Link>
            </div>

            <div class="mb-4 flex flex-col gap-2 sm:flex-row">
                <input
                    v-model="search"
                    @input="doSearch"
                    type="text"
                    placeholder="Cercar correu..."
                    class="w-full rounded-md border border-slate-300 px-3 py-1.5 text-sm text-slate-700 sm:w-auto"
                />
                <select
                    @change="handleFilterChange"
                    class="w-full rounded-md border border-slate-300 px-3 py-1.5 text-sm text-slate-700 sm:w-auto"
                >
                    <option>Tot</option>
                    <option>Actiu</option>
                    <option>Inactiu</option>
                </select>
            </div>

            <div
                v-if="displayedEmails && displayedEmails.length > 0"
                class="overflow-hidden overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm"
            >
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th
                                class="px-3 py-2 font-semibold text-slate-700 sm:px-6 sm:py-3"
                            >
                                Correu
                            </th>
                            <!-- <th class="px-6 py-3 font-semibold text-slate-700">
                                Estat
                            </th> -->
                            <th
                                class="px-3 py-2 font-semibold text-slate-700 sm:px-6 sm:py-3"
                            >
                                Accions
                            </th>
                            <th
                                class="px-3 py-2 font-semibold text-slate-700 sm:px-6 sm:py-3"
                            >
                                Selecciona
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr
                            v-for="email in displayedEmails"
                            :key="email.id"
                            class="hover:bg-slate-50"
                        >
                            <td
                                class="px-3 py-2 text-slate-800 sm:px-6 sm:py-4"
                            >
                                {{ email.email }}
                            </td>
                            <!-- <td class="px-6 py-4 text-slate-600">
                                {{ email.active === 1 ? 'Actiu' : 'Inactiu' }}
                            </td> -->
                            <td class="px-3 py-2 sm:px-6 sm:py-4">
                                <Link
                                    :href="`/admin/emails/${email.id}`"
                                    method="delete"
                                    as="button"
                                    preserve-scroll
                                >
                                    <Trash2
                                        class="h-4 w-4 text-slate-500 hover:text-red-500"
                                    />
                                </Link>
                            </td>
                            <td class="px-3 py-2 sm:px-6 sm:py-4">
                                <input
                                    type="checkbox"
                                    :disabled="
                                        selectedEmailIds.length >= 3 &&
                                        !selectedEmailIds.includes(email.id)
                                    "
                                    :id="`email-${email.id}`"
                                    :value="email.id"
                                    v-model="selectedEmailIds"
                                    @change="handleChange(email.id)"
                                    class="h-4 w-4 text-blue-600"
                                />
                                <label
                                    :for="`email-${email.id}`"
                                    class="sr-only"
                                >
                                    Seleccionar {{ email.email }}
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
