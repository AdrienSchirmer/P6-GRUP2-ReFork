<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { admindashboard as dashboard } from '@/routes';
import { create as usersCreate } from '@/routes/users';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

type User = {
    id: number;
    name: string;
    email: string;
    nickname?: string | null;
    role?: string | null;
    created_at?: string | null;
};

const props = defineProps<{
    users: User[];
    currentUser: User;
}>();

const page = usePage<{ flash?: { message?: string } }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Administració d'usuaris", href: dashboard().url },
];

const searchQuery = ref('');
const selectedRole = ref('');
const currentPage = ref(1);
const perPage = 8;

const filteredUsers = computed(() => {
    const query = searchQuery.value.trim().toLowerCase();

    return props.users
        .filter((user) => user.id !== props.currentUser.id)
        .filter((user) => {
            if (!query) return true;
            return (
                user.name.toLowerCase().includes(query) ||
                user.email.toLowerCase().includes(query) ||
                (user.nickname ?? '').toLowerCase().includes(query)
            );
        })
        .filter((user) => {
            if (!selectedRole.value) return true;
            return (user.role ?? '') === selectedRole.value;
        });
});

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredUsers.value.length / perPage)),
);

const visibleUsers = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    return filteredUsers.value.slice(start, start + perPage);
});

const canGoPrev = computed(() => currentPage.value > 1);
const canGoNext = computed(() => currentPage.value < totalPages.value);

const goPrev = () => {
    if (canGoPrev.value) currentPage.value -= 1;
};

const goNext = () => {
    if (canGoNext.value) currentPage.value += 1;
};

const resetPage = () => {
    currentPage.value = 1;
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Administració d'usuaris" />

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="rounded-xl border border-sidebar-border/70 bg-background p-6 dark:border-sidebar-border">
                <h1 class="text-2xl font-semibold tracking-tight">Administració d'usuaris</h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Consulta i filtra els usuaris del sistema.
                </p>
            </div>

            <div
                v-if="page.props.flash?.message"
                class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
                role="alert"
            >
                {{ page.props.flash?.message }}
            </div>

            <div class="rounded-xl border border-sidebar-border/70 bg-background p-5 dark:border-sidebar-border">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <input
                        v-model="searchQuery"
                        @input="resetPage"
                        type="search"
                        placeholder="Cerca per nom, email o nickname"
                        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                    />

                    <select
                        v-model="selectedRole"
                        @change="resetPage"
                        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm sm:w-auto"
                    >
                        <option value="">Tots els rols</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                    </select>

                    <Link
                        :href="usersCreate().url"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-[#0f5f7f] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#0c4a63] sm:ml-auto sm:w-auto"
                    >
                        Crear usuari
                    </Link>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-sidebar-border/70 text-sm">
                        <thead class="bg-muted/40">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Nom</th>
                                <th class="px-4 py-3 text-left font-semibold">Email</th>
                                <th class="px-4 py-3 text-left font-semibold">Usuari</th>
                                <th class="px-4 py-3 text-left font-semibold">Rol</th>
                                <th class="px-4 py-3 text-left font-semibold">Creat el</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sidebar-border/70">
                            <tr v-for="user in visibleUsers" :key="user.id" class="hover:bg-muted/30">
                                <td class="px-4 py-3 font-medium">{{ user.name }}</td>
                                <td class="px-4 py-3 text-muted-foreground">{{ user.email }}</td>
                                <td class="px-4 py-3 text-muted-foreground">{{ user.nickname || '—' }}</td>
                                <td class="px-4 py-3 text-muted-foreground">{{ user.role || '—' }}</td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{
                                        user.created_at
                                            ? new Date(user.created_at).toLocaleString('ca-ES')
                                            : '—'
                                    }}
                                </td>
                            </tr>

                            <tr v-if="visibleUsers.length === 0">
                                <td colspan="5" class="px-4 py-8 text-center text-muted-foreground">
                                    No s'han trobat usuaris amb aquests filtres.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <p class="text-xs text-muted-foreground">
                        Pàgina {{ currentPage }} de {{ totalPages }}
                    </p>
                    <div class="flex gap-2">
                        <button
                            class="rounded-md border border-sidebar-border px-3 py-1 text-sm disabled:opacity-40"
                            :disabled="!canGoPrev"
                            @click="goPrev"
                        >
                            Anterior
                        </button>
                        <button
                            class="rounded-md border border-sidebar-border px-3 py-1 text-sm disabled:opacity-40"
                            :disabled="!canGoNext"
                            @click="goNext"
                        >
                            Següent
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
