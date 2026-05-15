<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';
import { Icon } from '@iconify/vue';
</script>

<template>
    <Navbar />
    <div class="min-h-[80dvh]">
        <slot />
    </div>
    <div class="z-10 fixed right-0 bottom-0">
        <a
            href='https://wa.me/34'
            class="mr-4 mb-4 flex h-15 w-15 cursor-pointer justify-center rounded-4xl bg-[#08c004]"
        >
            <p class="size-0 opacity-0 absolute">Whatsapp</p>
            <Icon
                icon="fontisto:whatsapp"
                width="35"
                height="35"
                class="self-center text-white"
            ></Icon>
        </a>
    </div>
    <Footer />
</template>
