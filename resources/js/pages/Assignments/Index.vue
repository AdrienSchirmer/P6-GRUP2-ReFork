<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <WebAppLayout>
        <h1 class="mb-5">tens QUANTITAT encarrec</h1>
        <Link
            href="/assignments/create"
            class="m-5 rounded-2xl bg-blue-500 p-3 text-white"
            >Crear un encarrec</Link
        >
    </WebAppLayout>
</template>
