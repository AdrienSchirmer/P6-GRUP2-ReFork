<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { admindashboard as dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Pantalla d'inici", href: dashboard().url },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Admin" />

        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="rounded-xl border border-sidebar-border/70 bg-background p-6 dark:border-sidebar-border"
            >
                <h1 class="text-2xl font-semibold tracking-tight">
                    Panell d'administració
                </h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Aquí podràs gestionar les ultimes peticións!
                </p>
            </div>
        </div>
    </AppLayout>
</template>
