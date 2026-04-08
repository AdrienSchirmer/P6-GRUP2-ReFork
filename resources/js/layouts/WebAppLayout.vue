<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';

</script>

<template>
    <Navbar/>
    <div class="min-h-[80dvh] pt-20">
        <slot />
    </div>
    <Footer/>
</template>
