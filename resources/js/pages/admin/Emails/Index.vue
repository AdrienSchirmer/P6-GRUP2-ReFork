<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Trash2 } from 'lucide-vue-next';
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
            <h1 class="mb-6 text-2xl font-semibold">Configuració Correus</h1>
            <div
                v-if="emails && emails.length > 0"
                class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm"
            >
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-slate-700">
                                Correu
                            </th>
                            <th class="px-6 py-3 font-semibold text-slate-700">
                                Estat
                            </th>
                            <th class="px-6 py-3 font-semibold text-slate-700">
                                Accions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr
                            v-for="email in emails"
                            :key="email.id"
                            class="hover:bg-slate-50"
                        >
                            <td class="px-6 py-4 text-slate-800">
                                {{ email.email }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ email.active === 1 ? 'Actiu' : 'Inactiu' }}
                            </td>
                            <td class="px-6 py-4">
                                <Link>
                                    <Trash2
                                        class="h-4 w-4 text-slate-500 hover:text-red-500"
                                    />
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
