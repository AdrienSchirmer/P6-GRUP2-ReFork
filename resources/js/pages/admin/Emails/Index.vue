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
                class="grid grid-cols-1 gap-5 pr-10 md:grid-cols-2 lg:grid-cols-3"
                v-if="emails && emails.length > 0"
            >
                <div
                    v-for="email in emails"
                    :key="email.id"
                    class="relative m-6 flex w-full flex-col rounded-lg border border-slate-200 bg-white shadow-sm"
                >
                    <div class="p-4">
                        <h5 class="mb-2 text-xl font-semibold text-slate-800">
                            {{ email.email }}
                        </h5>
                        <p
                            v-if="email.active === 1"
                            class="leading-normal font-light text-slate-600"
                        >
                            Actiu
                        </p>
                        <Link>
                            <Trash2 />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
