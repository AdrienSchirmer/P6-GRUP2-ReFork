<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { index as pharmacyguardsIndex } from '@/routes/pharmacyguards';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Panell de guardies', href: pharmacyguardsIndex().url },
];
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="relative flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4 md:p-6"
        >
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
                    Panell de guardies
                </h1>
                <p class="mt-2 max-w-2xl text-sm text-muted-foreground">
                    Aquí podràs gestionar les guardies de la farmàcia, i
                    assegurar-te que tot estigui cobert de manera eficient.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
