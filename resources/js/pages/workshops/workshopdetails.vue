<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { Link } from '@inertiajs/vue3';
import WebAppLayout from '@/layouts/WebAppLayout.vue';

type Workshop = {
    id: number;
    name: string;
    description: string;
    photo_url: string | null;
    workshop_date: string;
    start_time: string;
    end_time: string;
    max_attendees: number | null;
};

defineProps<{
    workshop: Workshop;
}>();

const weekDays = [
    'Diumenge',
    'Dilluns',
    'Dimarts',
    'Dimecres',
    'Dijous',
    'Divendres',
    'Dissabte',
];
const months = [
    'Gener',
    'Febrer',
    'Març',
    'Abril',
    'Maig',
    'Juny',
    'Juliol',
    'Agost',
    'Setembre',
    'Octubre',
    'Novembre',
    'Desembre',
];

function formatDate(dateStr: string): string {
    const d = new Date(dateStr + 'T00:00:00');
    return `${weekDays[d.getDay()]}, ${d.getDate()} de ${months[d.getMonth()]}`;
}
</script>

<template>
    <WebAppLayout>
        <!-- Hero -->
        <section
            class="relative overflow-hidden bg-linear-to-br from-[#013F52] via-[#015873] to-[#01789E]"
        >
            <div
                class="pointer-events-none absolute -top-20 -right-20 h-72 w-72 rounded-full bg-white/5 blur-3xl"
            ></div>
            <div
                class="pointer-events-none absolute -bottom-12 -left-12 h-56 w-56 rounded-full bg-white/5 blur-3xl"
            ></div>

            <div
                class="relative mx-auto flex max-w-7xl flex-col items-start gap-3 px-6 py-12"
            >
                <Link
                    href="/workshops"
                    class="flex items-center gap-1.5 text-sm text-white/60 transition hover:text-white"
                >
                    <Icon icon="mdi:arrow-left" width="16" height="16" />
                    Tornar als tallers
                </Link>

                <div class="mt-2 flex items-center gap-2 text-white/60">
                    <Icon icon="mdi:school" width="16" height="16" />
                    <span
                        class="text-xs font-semibold tracking-widest uppercase"
                        >Farmàcia Soler</span
                    >
                </div>

                <h1 class="text-3xl font-bold text-white lg:text-4xl">
                    {{ workshop.name }}
                </h1>

                <div class="mt-1 flex flex-wrap gap-3">
                    <span
                        class="flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-sm text-white/80 backdrop-blur-sm"
                    >
                        <Icon icon="mdi:calendar" width="15" height="15" />
                        {{ formatDate(workshop.workshop_date) }}
                    </span>
                    <span
                        class="flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-sm text-white/80 backdrop-blur-sm"
                    >
                        <Icon icon="mdi:clock-outline" width="15" height="15" />
                        {{ workshop.start_time }} – {{ workshop.end_time }}
                    </span>
                    <span
                        class="flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-sm text-white/80 backdrop-blur-sm"
                    >
                        <Icon icon="mdi:account-group" width="15" height="15" />
                        {{
                            workshop.max_attendees
                                ? `${workshop.max_attendees} places`
                                : 'Places il·limitades'
                        }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Body -->
        <section class="bg-[#F2FAFF] px-4 py-12 md:px-24">
            <div class="mx-auto flex max-w-5xl flex-col gap-10 lg:flex-row">
                <!-- Photo -->
                <div class="flex-shrink-0 lg:w-72 xl:w-80">
                    <div
                        class="overflow-hidden rounded-2xl border border-[#D0EAF3] bg-white shadow-md shadow-[#01617F]/8"
                    >
                        <img
                            v-if="workshop.photo_url"
                            :src="workshop.photo_url"
                            :alt="workshop.name"
                            class="h-full w-full object-contain"
                        />
                        <div
                            v-else
                            class="flex aspect-[3/4] flex-col items-center justify-center gap-3 bg-linear-to-br from-[#015873] to-[#01789E]"
                        >
                            <Icon
                                icon="mdi:school"
                                class="text-white/30"
                                width="56"
                                height="56"
                            />
                            <p class="text-sm font-medium text-white/50">
                                {{ workshop.name }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="flex flex-1 flex-col gap-6">
                    <!-- Description -->
                    <div
                        class="rounded-2xl border border-[#D0EAF3] bg-white p-6 shadow-sm"
                    >
                        <h2
                            class="mb-3 flex items-center gap-2 text-sm font-semibold tracking-widest text-[#01617F] uppercase"
                        >
                            <Icon icon="mdi:text" width="16" height="16" />
                            Descripció
                        </h2>
                        <p
                            class="text-sm leading-relaxed whitespace-pre-wrap text-[#335B69]"
                        >
                            {{ workshop.description }}
                        </p>
                    </div>

                    <!-- Details -->
                    <div
                        class="rounded-2xl border border-[#D0EAF3] bg-white p-6 shadow-sm"
                    >
                        <h2
                            class="mb-4 flex items-center gap-2 text-sm font-semibold tracking-widest text-[#01617F] uppercase"
                        >
                            <Icon
                                icon="mdi:information-outline"
                                width="16"
                                height="16"
                            />
                            Informació
                        </h2>
                        <dl class="flex flex-col gap-3">
                            <div class="flex items-center gap-3">
                                <Icon
                                    icon="mdi:calendar"
                                    class="shrink-0 text-[#01617F]"
                                    width="18"
                                    height="18"
                                />
                                <div>
                                    <dt class="text-xs text-[#335B69]/60">
                                        Data
                                    </dt>
                                    <dd
                                        class="text-sm font-medium text-[#0E3C4D]"
                                    >
                                        {{ formatDate(workshop.workshop_date) }}
                                    </dd>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <Icon
                                    icon="mdi:clock-outline"
                                    class="shrink-0 text-[#01617F]"
                                    width="18"
                                    height="18"
                                />
                                <div>
                                    <dt class="text-xs text-[#335B69]/60">
                                        Horari
                                    </dt>
                                    <dd
                                        class="text-sm font-medium text-[#0E3C4D]"
                                    >
                                        {{ workshop.start_time }} –
                                        {{ workshop.end_time }}
                                    </dd>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <Icon
                                    icon="mdi:account-group"
                                    class="shrink-0 text-[#01617F]"
                                    width="18"
                                    height="18"
                                />
                                <div>
                                    <dt class="text-xs text-[#335B69]/60">
                                        Places màximes
                                    </dt>
                                    <dd
                                        class="text-sm font-medium text-[#0E3C4D]"
                                    >
                                        {{
                                            workshop.max_attendees
                                                ? workshop.max_attendees
                                                : 'Il·limitades'
                                        }}
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </section>
    </WebAppLayout>
</template>
