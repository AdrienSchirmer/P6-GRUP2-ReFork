<script setup lang="ts">
import { Icon } from "@iconify/vue";
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
</script>
 
<template>
    <Navbar/>
    <div class="bg-white py-12 px-2 md:px-24">
        <div class="border-2 rounded justify-between text-black flex w-full flex-col md:flex-row max-h-5/2">
            <div class="md:relative h-110 md:h-auto w-full md:w-1/2 overflow-hidden flex items-end">
                <img src="farmaciaSoler.jpeg" alt="Farmacia Soler" class="object-cover object-bottom w-full h-full md:absolute rounded-l">
            </div>
            <div class="md:w-1/2 px-8 py-16 md:py-34 flex flex-col gap-4">
                <h2 class="text-2xl md:text-4xl text-center md:text-left font-bold">Contactan's</h2>
                <div>
                    <h3 class="text-xl font-medium">Horari d'atenció</h3>
                    <div class="pl-6 pt-4">
                        <li>Dilluns: 8:30 am - 8:30 pm</li>
                        <li>Dimarts: 8:30 am - 8:30 pm</li>
                        <li>Dimecres: 8:30 am - 8:30 pm</li>
                        <li>Dijous: 8:30 am - 8:30 pm</li>
                        <li>Divendres: 8:30 am - 8:30 pm</li>
                        <li>Dissabte: 8:30 am - 8:30 pm</li>
                        <li>Diumenge: Tancat</li>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex gap-1">
                        <Icon icon="ic:mail" width="24" height="24"></Icon>
                        <a href="tel:+34972500299">+34972500299</a>
                    </div>
                    <div class="flex gap-1">
                        <Icon icon="ic:outline-phone" width="24" height="24"></Icon>
                        <a href="tel:+34972500299">+34 972 50 02 99</a>
                    </div>
                    <div class="flex gap-1">
                        <Icon icon="ic:outline-phone" width="24" height="24"></Icon>
                        <a href="tel:+34972500299">+34 972 50 02 99</a>
                    </div>
                    <div class="flex gap-1">
                        <Icon icon="ic:twotone-facebook" width="24" height="24"></Icon>
                        <a href="tel:+34972500299">+34972500299</a>
                    </div>
                </div>
                <p class="text-gray-700 underline italic">Carrer Nou, 22, 17600 Figueres, Girona, Spain</p>
            </div>
        </div>
    </div>
    <Footer/>
</template>