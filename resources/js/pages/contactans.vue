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
            <div class="md:w-1/2 px-8 py-8 md:py-16 flex flex-col gap-4">
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
                    </div>
                    <div class="flex gap-1">
                        <Icon icon="ri:phone-fill" width="24" height="24"></Icon>
                        <a href="tel:+34972500299">972 50 02 99</a>
                    </div>
                    <div class="flex gap-1">
                        <Icon icon="ri:instagram-fill" width="24" height="24"></Icon>
                        <a href="https://www.instagram.com/farmaciasolerfigueres/">farmaciasolerfigueres</a>
                    </div>
                    <div class="flex gap-1">
                        <Icon icon="mage:tiktok-circle" width="24" height="24"></Icon>
                        <a href="https://www.tiktok.com/@farmaciasoler">farmaciasoler</a>
                    </div>
                    <div class="flex gap-1">
                        <Icon icon="ic:twotone-facebook" width="24" height="24"></Icon>
                        <a href="https://es-es.facebook.com/farmaciasolerfigueres">farmaciasolerfigueres</a>
                    </div>
                </div>
                <p class="text-gray-700 underline italic">Carrer Nou, 22, 17600 Figueres, Girona, Spain</p>
            </div>
        </div>
    </div>
    <Footer/>
    <div class="sticky bottom-0 flex justify-end">
        <a class="h-15 w-15 mr-4 mb-4 bg-[#08c004] rounded-4xl flex justify-center cursor-pointer" href="https://wa.me/34658359458?text=Hola%2C%20estoy%20interesado%20en%20">
            <Icon icon="fontisto:whatsapp" width="35" height="35" class="text-white self-center"></Icon>
        </a>
    </div>
</template>