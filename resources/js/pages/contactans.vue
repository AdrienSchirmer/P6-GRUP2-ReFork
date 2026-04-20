<script setup lang="ts">
import { Icon } from '@iconify/vue';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
</script>

<template>
    <Navbar />
    <div class="bg-white px-2 py-12 md:px-24">
        <div
            class="flex max-h-5/2 w-full flex-col justify-between rounded border-2 text-black md:flex-row"
        >
            <div
                class="flex h-110 w-full items-end overflow-hidden md:relative md:h-auto md:w-1/2"
            >
                <img
                    src="farmaciaSoler.jpeg"
                    alt="Farmacia Soler"
                    class="h-full w-full rounded-l object-cover object-bottom md:absolute"
                />
            </div>
            <div class="flex flex-col gap-4 px-8 py-8 md:w-1/2 md:py-16">
                <h2
                    class="text-center text-2xl font-bold md:text-left md:text-4xl"
                >
                    Contactan's
                </h2>
                <div>
                    <h3 class="text-xl font-medium">Horari d'atenció</h3>
                    <div class="pt-4 pl-6">
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
                        <a href=""></a>
                    </div>
                    <div class="flex gap-1">
                        <Icon
                            icon="ri:whatsapp-fill"
                            width="24"
                            height="24"
                        ></Icon>
                        <a
                            href="https://wa.me/34972500299?text=Hola%2C%20estoy%20interesado%20en%20"
                            >+34 972 50 02 99</a
                        >
                    </div>
                    <div class="flex gap-1">
                        <Icon
                            icon="ri:instagram-fill"
                            width="24"
                            height="24"
                        ></Icon>
                        <a
                            href="https://www.instagram.com/farmaciasolerfigueres/"
                            >farmaciasolerfigueres</a
                        >
                    </div>
                    <div class="flex gap-1">
                        <Icon
                            icon="mage:tiktok-circle"
                            width="24"
                            height="24"
                        ></Icon>
                        <a href="https://www.tiktok.com/@farmaciasoler"
                            >farmaciasoler</a
                        >
                    </div>
                    <div class="flex gap-1">
                        <Icon
                            icon="ic:twotone-facebook"
                            width="24"
                            height="24"
                        ></Icon>
                        <a
                            href="https://es-es.facebook.com/farmaciasolerfigueres"
                            >farmaciasolerfigueres</a
                        >
                    </div>
                </div>
                <p class="text-gray-700 italic underline">
                    Carrer Nou, 22, 17600 Figueres, Girona, Spain
                </p>
            </div>
        </div>
    </div>
    <Footer />
</template>
