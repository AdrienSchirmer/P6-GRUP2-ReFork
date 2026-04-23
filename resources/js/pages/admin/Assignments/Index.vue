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
        <div class="flex items-center justify-center px-10 pt-5">
            <div class="relative flex w-full max-w-md justify-between">
                <input
                    type="text"
                    placeholder="Search..."
                    class="w-full rounded-2xl border border-gray-300 bg-white py-2 pr-10 pl-4 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <svg
                    class="absolute top-1/2 right-3 h-4 w-4 -translate-y-1/2 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
            </div>
        </div>

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
