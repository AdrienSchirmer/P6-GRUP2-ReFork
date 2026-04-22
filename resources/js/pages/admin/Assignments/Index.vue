<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Administració de Encarrecs', href: 'admin/adminAssignments' },
];

defineProps<{
    assignments: {
        name: string;
        address: string;
        phone_number: number;
        description: string;
        status: string;
        created_at: string;
        updated_at: string;
    }[];
}>();

import { format } from 'timeago.js';
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-1 gap-5 pr-10 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="ass in assignments"
                :key="ass.name"
                class="relative m-6 flex w-full flex-col rounded-lg border border-slate-200 bg-white shadow-sm"
            >
                <div
                    class="mx-3 mb-0 flex flex-col border-b border-slate-200 px-1 pt-3 pb-2"
                >
                    <span class="text-sm text-slate-600">
                        <strong>Estat:</strong> {{ ass.status }}
                    </span>
                    <span class="text-sm text-slate-600">
                        <strong>Correu:</strong> {{ ass.address }}
                    </span>
                    <span class="text-sm text-slate-600">
                        <strong>Tél:</strong> {{ ass.phone_number }}
                    </span>
                </div>

                <div class="p-4">
                    <h5 class="mb-2 text-xl font-semibold text-slate-800">
                        {{ ass.name }}
                    </h5>
                    <p class="leading-normal font-light text-slate-600">
                        {{ ass.description }}
                    </p>
                </div>
                <div class="mx-3 border-t border-slate-200 px-1 pt-2 pb-3">
                    <span class="text-sm font-medium text-slate-600">
                        {{ format(ass.updated_at) }}
                    </span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
