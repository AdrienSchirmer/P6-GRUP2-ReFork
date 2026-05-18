<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { computed, onMounted, ref } from 'vue';
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import 'leaflet';
import 'leaflet/dist/leaflet.css';

const map = ref();

// Open between 8:30 and 20:30 every day except Sunday.
const isOpenNow = computed(() => {
    const now = new Date();
    if (now.getDay() === 0) return false;
    const minutes = now.getHours() * 60 + now.getMinutes();
    return minutes >= 8 * 60 + 30 && minutes < 20 * 60 + 30;
});

onMounted(() => {
    map.value = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: false,
    }).setView(['42.2655267', '2.9631527'], 18);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap',
    }).addTo(map.value);
    L.marker(['42.2655267', '2.9631527'])
        .addTo(map.value)
        .bindPopup('<b>Farmàcia Soler</b><br>Carrer Nou, 22 · Figueres')
        .openPopup();
});
</script>

<template>
    <Head>
        <title>Contacta'ns</title>
        <meta
            name="description"
            content="Posa't en contacte amb Farmàcia Soler. Estem aquí per ajudar-te."
        />
    </Head>
    <WebAppLayout>
        <div class="relative min-h-screen overflow-hidden bg-slate-50">
            <!-- Decorative background -->
            <div
                class="pointer-events-none absolute inset-x-0 top-0 -z-0 h-[420px] bg-gradient-to-br from-[#00617E] via-[#0a7494] to-[#003d50]"
            ></div>
            <div
                class="pointer-events-none absolute inset-x-0 top-0 -z-0 h-[420px] opacity-[0.06]"
                style="
                    background-image: radial-gradient(
                        circle at 1px 1px,
                        white 1px,
                        transparent 0
                    );
                    background-size: 24px 24px;
                "
            ></div>

            <div
                class="relative z-10 mx-auto max-w-7xl px-4 pt-10 pb-16 sm:px-6 lg:px-8"
            >
                <!-- Hero -->
                <div
                    class="mb-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between"
                >
                    <div class="max-w-2xl">
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold tracking-wider text-white uppercase backdrop-blur-sm"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full"
                                :class="
                                    isOpenNow
                                        ? 'animate-pulse bg-emerald-400'
                                        : 'bg-rose-400'
                                "
                            ></span>
                            {{ isOpenNow ? 'Oberts ara' : 'Tancats ara' }}
                        </span>
                        <h1
                            class="mt-4 text-4xl font-bold tracking-tight text-white sm:text-5xl"
                        >
                            Contacta amb nosaltres
                        </h1>
                        <p class="sm:text-l mt-3 text-base text-white/80">
                            Som a Figueres, oberts de dilluns a dissabte.
                            Truca'ns o vine directament a la farmàcia.
                        </p>
                    </div>
                </div>

                <!-- Main grid -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
                    <!-- Map card -->
                    <div class="lg:col-span-3">
                        <div
                            class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-900/5"
                        >
                            <div
                                id="map"
                                class="z-0 h-80 w-full sm:h-[28rem] lg:h-full lg:min-h-[32rem]"
                            ></div>
                        </div>
                        <a
                            href="https://www.openstreetmap.org/?mlat=42.2655267&mlon=2.9631527#map=18/42.2655267/2.9631527"
                            target="_blank"
                            rel="noopener"
                            class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-white/90 hover:text-white"
                        >
                            <Icon
                                icon="mdi:directions"
                                width="16"
                                height="16"
                            />
                            Com arribar
                            <Icon
                                icon="mdi:arrow-top-right"
                                width="14"
                                height="14"
                            />
                        </a>
                    </div>

                    <!-- Info column -->
                    <div class="space-y-5 lg:col-span-2">
                        <!-- Hours card -->
                        <div
                            class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-900/5"
                        >
                            <div
                                class="flex items-center gap-3 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4"
                            >
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#00617E] to-[#004e66] text-white shadow-md ring-4 shadow-[#00617E]/20 ring-[#00617E]/10"
                                >
                                    <Icon
                                        icon="mdi:clock-outline"
                                        width="20"
                                        height="20"
                                    />
                                </span>
                                <div>
                                    <h2
                                        class="text-base font-semibold text-slate-900"
                                    >
                                        Horari d'atenció
                                    </h2>
                                </div>
                            </div>
                            <div class="divide-y divide-slate-100">
                                <div
                                    class="flex items-center justify-between px-6 py-4"
                                >
                                    <span class="text-sm text-slate-700">
                                        De dilluns a dissabte
                                    </span>
                                    <span
                                        class="text-sm font-semibold text-slate-900 tabular-nums"
                                    >
                                        8:30 - 20:30
                                    </span>
                                </div>
                                <div
                                    class="flex items-center justify-between px-6 py-4"
                                >
                                    <span class="text-sm text-slate-700">
                                        Diumenge
                                    </span>
                                    <span
                                        class="text-sm font-semibold text-rose-500"
                                    >
                                        Tancat
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact card -->
                        <div
                            class="overflow-hidden rounded-2xl bg-gradient-to-br from-[#00617E] to-[#004e66] p-6 text-white shadow-xl"
                        >
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/15 backdrop-blur-sm"
                                >
                                    <Icon
                                        icon="ri:phone-fill"
                                        width="20"
                                        height="20"
                                    />
                                </span>
                                <h3 class="text-base font-semibold">
                                    Posa't en contacte
                                </h3>
                            </div>
                            <p class="mt-3 text-sm text-white/80">
                                Pots trucar-nos directament o vine a veure'ns
                                durant l'horari d'atenció.
                            </p>
                            <a
                                href="tel:+34972500299"
                                class="mt-4 flex items-center justify-between rounded-lg bg-white/10 px-4 py-3 text-sm font-semibold backdrop-blur-sm transition hover:bg-white hover:text-[#00617E]"
                            >
                                <span class="flex items-center gap-2">
                                    <Icon
                                        icon="ri:phone-fill"
                                        width="16"
                                        height="16"
                                    />
                                    972 50 02 99
                                </span>
                                <Icon
                                    icon="mdi:arrow-right"
                                    width="16"
                                    height="16"
                                />
                            </a>
                            <a
                                href="mailto:info@farmaciasoler.com"
                                class="mt-2 flex items-center justify-between rounded-lg bg-white/10 px-4 py-3 text-sm font-semibold backdrop-blur-sm transition hover:bg-white hover:text-[#00617E]"
                            >
                                <span class="flex items-center gap-2">
                                    <Icon
                                        icon="ic:mail"
                                        width="16"
                                        height="16"
                                    />
                                    info@farmaciasoler.com
                                </span>
                                <Icon
                                    icon="mdi:arrow-right"
                                    width="16"
                                    height="16"
                                />
                            </a>
                            <div
                                class="mt-4 flex items-start gap-2 text-xs text-white/70"
                            >
                                <Icon
                                    icon="mdi:map-marker"
                                    width="14"
                                    height="14"
                                    class="mt-0.5 shrink-0"
                                />
                                Carrer Nou, 22 · 17600 Figueres, Girona
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </WebAppLayout>
</template>

<style scoped>
:deep(.leaflet-container) {
    font-family: inherit;
}
:deep(.leaflet-popup-content-wrapper) {
    border-radius: 0.5rem;
}
</style>
