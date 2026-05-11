<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type {BreadcrumbItem} from '@/types';
import { admindashboard as dashboard } from '@/routes';
import { create as usersCreate } from '@/routes/users';

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
            if (!query) {
return true;
}

            return (
                user.name.toLowerCase().includes(query) ||
                user.email.toLowerCase().includes(query) ||
                (user.nickname ?? '').toLowerCase().includes(query)
            );
        })
        .filter((user) => {
            if (!selectedRole.value) {
return true;
}

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
    if (canGoPrev.value) {
currentPage.value -= 1;
}
};

const goNext = () => {
    if (canGoNext.value) {
currentPage.value += 1;
}
};

const resetPage = () => {
    currentPage.value = 1;
};

const roleBadgeClass = (role?: string | null) => {
    if (role === 'superadmin') {
        return 'border-zinc-300 bg-zinc-100 text-zinc-800';
    }

    if (role === 'admin') {
        return 'border-zinc-300 bg-zinc-50 text-zinc-700';
    }

    return 'border-sidebar-border/80 bg-muted text-muted-foreground';
};

const roleLabel = (role?: string | null) => {
    if (role === 'superadmin') {
return 'Superadmin';
}

    if (role === 'admin') {
return 'Admin';
}

    return '—';
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Administració d'usuaris" />

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
                    Administració d'usuaris
                </h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Visualitza i gestiona els usuaris interns de manera ràpida i
                    clara.
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
                class="relative rounded-2xl border border-sidebar-border/70 bg-background/95 p-5 shadow-sm"
            >
                <div
                    class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center"
                >
                    <input
                        v-model="searchQuery"
                        @input="resetPage"
                        type="search"
                        placeholder="Cerca per nom, email o nickname"
                        class="w-full rounded-xl border border-sidebar-border/80 bg-background px-3 py-2 text-sm shadow-xs transition focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/30 focus-visible:outline-none"
                    />

                    <select
                        v-model="selectedRole"
                        @change="resetPage"
                        class="w-full rounded-xl border border-sidebar-border/80 bg-background px-3 py-2 text-sm shadow-xs transition focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/30 focus-visible:outline-none sm:w-auto"
                    >
                        <option value="">Tots els rols</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                    </select>

                    <Link
                        :href="usersCreate().url"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition hover:bg-primary/90 sm:ml-auto sm:w-auto"
                    >
                        Crear usuari
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
                                    Email
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Usuari
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Rol
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-foreground/80 uppercase"
                                >
                                    Creat el
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sidebar-border/70">
                            <tr
                                v-for="user in visibleUsers"
                                :key="user.id"
                                class="transition-colors hover:bg-muted/30"
                            >
                                <td class="px-4 py-3 font-medium">
                                    {{ user.name }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ user.email }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ user.nickname || '—' }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    <span
                                        class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                        :class="roleBadgeClass(user.role)"
                                    >
                                        {{ roleLabel(user.role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{
                                        user.created_at
                                            ? new Date(
                                                  user.created_at,
                                              ).toLocaleString('ca-ES')
                                            : '—'
                                    }}
                                </td>
                            </tr>

                            <tr v-if="visibleUsers.length === 0">
                                <td
                                    colspan="5"
                                    class="px-4 py-8 text-center text-muted-foreground"
                                >
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
                            class="rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm transition hover:bg-sidebar-accent/45 disabled:opacity-40"
                            :disabled="!canGoPrev"
                            @click="goPrev"
                        >
                            Anterior
                        </button>
                        <button
                            class="rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm transition hover:bg-sidebar-accent/45 disabled:opacity-40"
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
