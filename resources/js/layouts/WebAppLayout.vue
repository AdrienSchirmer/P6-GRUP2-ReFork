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
    <div class="fixed right-0 bottom-0 z-10">
        <a
            href="https://wa.me/34658359458"
            class="mr-4 mb-4 flex h-15 w-15 cursor-pointer justify-center rounded-4xl bg-[#08c004]"
        >
            <p class="size-0 opacity-0 absolute">Whatsapp</p>
            <Icon
                icon="fontisto:whatsapp"
                width="35"
                height="35"
                class="self-center text-white">
            </Icon>
        </a>
    </div>

    <Footer />

    <a
        href="https://wa.me/34"
        target="_blank"
        rel="noopener noreferrer"
        class="fixed right-4 bottom-4 z-50 flex h-15 w-15 items-center justify-center rounded-full bg-[#25D366] shadow-lg transition hover:scale-110 hover:bg-[#1ebe5d]"
        aria-label="Contacta'ns per WhatsApp"
    >
        <Icon
            icon="fontisto:whatsapp"
            width="30"
            height="30"
            class="text-white"
        />
    </a>
</template>
