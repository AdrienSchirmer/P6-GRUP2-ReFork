<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
</script>

<template>
    <Navbar />
    <div class="min-h-[80dvh]">
        <slot />
    </div>
    <Footer />
</template>
