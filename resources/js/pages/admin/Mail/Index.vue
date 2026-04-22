<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Administració del Mail', href: 'admin/mail' },
];

import { Form } from '@inertiajs/vue3';
import { store } from '@/routes/mail';

defineProps<{
    mail: {
        mail_mailer: string;
        mail_scheme: string;
        mail_host: string;
        mail_port: string;
        mail_username: string;
        mail_from_address: string;
    };
}>();
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs"> </AppLayout>
</template>
