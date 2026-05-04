<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isMobileMenuOpen = ref(false);
</script>

<template>
  <nav class="sticky top-0 z-20 w-full border-b bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">


      <div class="flex items-center gap-6">

        <!-- Logo -->
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse"> <img class="w-90"
            src="/storage/FarmaciaSolerLogoLong.jpeg" alt="Long Logo" /> </a>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex items-center gap-6 text-lg font-medium text-[#4D3701]">
          <li>
            <Link href="/pedir-cita" class="hover:text-brand transition">
              Demanar cita
            </Link>
          </li>
          <li>
            <Link href="/assignments/create" class="hover:text-brand transition">
              Demanar encàrrec
            </Link>
          </li>
          <li>
            <Link href="/contactans" class="hover:text-brand transition">
              Contacta’ns
            </Link>
          </li>
        </ul>

      </div>

      <div class="flex items-center gap-2">


        <button
          class="hidden sm:block bg-brand hover:bg-brand-strong text-white text-sm px-4 py-2 rounded-md transition">
          Get started
        </button>

        <button class="md:hidden flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-100"
          @click="isMobileMenuOpen = !isMobileMenuOpen">
          <span class="sr-only">Open menu</span>
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
          </svg>
        </button>

      </div>
    </div>

    <!-- MOBILE MENU -->
    <div v-show="isMobileMenuOpen" class="md:hidden border-t bg-white px-4 py-4">
      <ul class="flex flex-col gap-4 text-base font-medium text-[#4D3701]">

        <li>
          <Link href="/pedir-cita" class="block py-2 hover:text-brand transition" @click="isMobileMenuOpen = false">
            Demanar cita
          </Link>
        </li>

        <li>
          <Link href="/assignments/create" class="block py-2 hover:text-brand transition"
            @click="isMobileMenuOpen = false">
            Demanar encàrrec
          </Link>
        </li>

        <li>
          <Link href="/contactans" class="block py-2 hover:text-brand transition" @click="isMobileMenuOpen = false">
            Contacta’ns
          </Link>
        </li>

      </ul>
    </div>
  </nav>
</template>