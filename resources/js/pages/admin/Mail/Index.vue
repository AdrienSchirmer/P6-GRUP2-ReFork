<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Administració del Mail', href: 'admin/mail' },
];
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs"> </AppLayout>
</template>
