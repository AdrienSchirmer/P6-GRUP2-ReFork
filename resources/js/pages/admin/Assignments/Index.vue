<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Administració de Encarrecs', href: 'admin/adminAssignments' },
];
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs"> <h1>hola</h1></AppLayout>
</template>
