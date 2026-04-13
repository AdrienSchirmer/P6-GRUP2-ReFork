<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Admin',
                href: '/admin',
            },
        ],
    },
});
</script>

<template>
    <Head title="Admin" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div
            class="rounded-xl border border-sidebar-border/70 bg-background p-6 dark:border-sidebar-border"
        >
            <h1 class="text-2xl font-semibold tracking-tight">Admin panel</h1>
            <p class="mt-2 text-sm text-muted-foreground">
                Manage your app from this section.
            </p>
        </div>
    </div>
</template>
