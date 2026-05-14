<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Administració dels Correus', href: 'admin/emails' },
];
defineProps<{
    emails?: {
        id: number;
        email: string;
        active: number;
    }[];
}>();
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <div
                v-if="$page.flash.message"
                class="mx-auto mt-4 mb-4 w-full rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-3xl text-black"
                role="alert"
            >
                <p>
                    <span class="font-medium">Creat: </span>
                    {{ $page.flash.message }}
                </p>
            </div>
            <h1 class="mb-6 text-2xl font-semibold">Configuració Correus</h1>
        </div>
    </AppLayout>
</template>
