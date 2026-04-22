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
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <p>Assignments</p>
            <p v-for="ass in assignments" :key="ass.name">{{ ass.name }}</p>
        </div>
    </AppLayout>
</template>
