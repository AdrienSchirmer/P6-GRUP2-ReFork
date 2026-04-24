<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isMobileMenuOpen = ref(false);
</script>
<template>
    <nav
        class="border-default sticky inset-s-0 top-0 z-20 w-full border-b bg-[#FFFFFF]"
    >
        <div
            class="mx-auto flex max-w-7xl flex-wrap items-center justify-between p-4"
        >
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img
                    class="w-90"
                    src="/storage/FarmaciaSolerLogoLong.jpeg"
                    alt="Long Logo"
                />
            </a>
            <div
                class="flex space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse"
            >
                <button
                    type="button"
                    class="bg-brand hover:bg-brand-strong focus:ring-brand-medium rounded-base box-border border border-transparent px-3 py-2 text-sm leading-5 font-medium text-white shadow-xs focus:ring-4 focus:outline-none"
                >
                    Get started
                </button>
                <button
                    type="button"
                    class="text-body rounded-base hover:bg-neutral-secondary-soft hover:text-heading focus:ring-neutral-tertiary inline-flex h-10 w-10 items-center justify-center p-2 text-sm focus:ring-2 focus:outline-none md:hidden"
                    aria-controls="navbar-sticky"
                    :aria-expanded="isMobileMenuOpen"
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="h-6 w-6"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h14"
                        />
                    </svg>
                </button>
            </div>
            <div
                :class="[
                    isMobileMenuOpen ? 'flex' : 'hidden',
                    'w-full items-center justify-between md:order-1 md:flex md:w-auto',
                ]"
                id="navbar-sticky"
            >
                <ul
                    class="border-default rounded-base bg-neutral-secondary-soft md:bg-neutral-primary mt-4 flex flex-col border p-4 text-2xl font-medium text-[#4D3701] italic md:mt-0 md:flex-row md:space-x-8 md:border-0 md:p-0 rtl:space-x-reverse"
                >
                    <Link href="/pedir-cita"> Demanar cita </Link>
                    <Link href="/assignments/create"> Demanar encarrec </Link>
                    <Link href="/contactans"> Contactan’s </Link>
                </ul>
            </div>
        </div>
    </nav>
</template>
