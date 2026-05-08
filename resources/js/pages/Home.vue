<script setup lang="ts">
import { Icon } from '@iconify/vue';
import 'leaflet';
import 'leaflet/dist/leaflet.css';
import Swiper from 'swiper';
import { Autoplay, Pagination } from 'swiper/modules';
import { onMounted, ref } from 'vue';
import Card from '@/components/Card.vue';
import WebAppLayout from '@/layouts/WebAppLayout.vue';

const map = ref();
const marker = ref();

onMounted(() => {
    const date = new Date();

    selectedDay.value = date.getDate();
    const jsDay = date.getDay(); // 0..6 (domingo..sábado)
    idWeekDay.value = jsDay === 0 ? 6 : jsDay - 1; // 0..6 (lunes..domingo)
    startWeekDay.value = idWeekDay.value;
    selectedWeekIndex.value = 0;
    idMonth.value = selectedMonth.value.num = date.getMonth();
    numYear.value = selectedYear.value = date.getFullYear();

    console.log(idMonth, selectedMonth, numYear, selectedYear);

    address.value = document.getElementById('address');
    address.value?.setAttribute(
        'href',
        'https://www.google.com/maps/search@' +
            pharmacy.lat.value +
            ',' +
            pharmacy.long.value +
            ',17z',
    );

    // const swiper = new Swiper('.swiper', {
    //     modules: [Pagination, Autoplay],
    //     autoplay: {
    //         delay: 3000,
    //     },
    //     pagination: {
    //         el: '.swiper-pagination',
    //     },
    // });

    new Swiper('.swiper', {
        modules: [Pagination, Autoplay],
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
        },
    });

    // Setup Map
    map.value = L.map('map').setView(
        [pharmacy.lat.value, pharmacy.long.value],
        19,
    );
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map.value);
    marker.value = L.marker([pharmacy.lat.value, pharmacy.long.value]).addTo(
        map.value,
    );

    setDays();
    setMonthName();
    setSelectDate(idWeekDay.value, selectedDay.value);
});

const address = ref();

const pharmacy = {
    // Test Information
    name: ref(''),
    dia: ref(''),
    description: ref(''),
    lat: ref('42.2655267'),
    long: ref('2.9631527'),
};

// ID's
const selectedDay = ref();
const selectedYear = ref();
const idWeekDay = ref();
const startWeekDay = ref();
const selectedWeekIndex = ref(0);
const idMonth = ref();
const numYear = ref();

// Names
const nameWeekDay = [
    'Dilluns',
    'Dimarts',
    'Dimecres',
    'Dijous',
    'Divendres',
    'Dissabte',
    'Diumenge',
];
const nameMonth = [
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

// Week Days
const week = {
    mon: ref(),
    tue: ref(),
    wed: ref(),
    thu: ref(),
    fri: ref(),
    sat: ref(),
    sun: ref(),
};
// Selected Month Info
const selectedMonth = ref({
    num: ref(),
    name: ref(''),
    double: false,
});

// Function get max day from month
function getMaxDay(): number {
    return new Date(numYear.value, idMonth.value + 1, 0).getDate();
}

/// Buttons

// Button Select Day
function setSelectDate(idWeek: number, day: number) {
    selectedDay.value = day;
    selectedWeekIndex.value = idWeek;
    idWeekDay.value = (startWeekDay.value + idWeek) % 7;
    selectedMonth.value.num =
        selectedMonth.value.double && day < 7 ? getNextMonth() : idMonth.value;
    selectedYear.value =
        selectedMonth.value.double && selectedMonth.value.num == 0
            ? numYear.value + 1
            : numYear.value;
    getPharmacyInfo(
        selectedDay.value,
        selectedMonth.value.num + 1,
        selectedYear.value,
    );
}
// Button Previous Week
function setPreviousWeek() {
    if (week.mon.value < 7) {
        setPreviousMonth();
    }
    const limitDay = getMaxDay();
    for (const [, value] of Object.entries(week)) {
        if ((value.value -= 7) < 1) {
            value.value += limitDay;
        }
        if (value.value === 1) {
            setMonthName();
        }
    }
    if (selectedMonth.value.double || week.sun.value == limitDay) {
        setMonthName();
    }
}

// Button Next Week
function setNextWeek() {
    const limitDay = getMaxDay();
    for (const [, value] of Object.entries(week)) {
        if ((value.value += 7) > limitDay) {
            if ((value.value -= limitDay) == 1) {
                setMonthName();
            }
        }
        if (value.value == 8 && selectedMonth.value.double) {
            setNextMonth();
            setMonthName();
        }
    }
    if (week.mon.value == 1 && week.sun.value == 7) {
        setNextMonth();
        setMonthName();
    }
}

/// Functions

// Function Get Pharmacy Info
async function getPharmacyInfo(day: number, month: number, year: number) {
    const reponse = await fetch(`/pharmacyguard/${year}-${month}-${day}`);

    const data = await reponse.json();

    if (data.success) {
        pharmacy.name.value = data.response.name;
        pharmacy.description.value = data.response.description;
        pharmacy.lat.value = data.response.latitude;
        pharmacy.long.value = data.response.longitude;
        console.log(data.response);

        address.value.setAttribute(
            'href',
            'https://www.google.com/maps/@' +
                pharmacy.lat.value +
                ',' +
                pharmacy.long.value +
                ',17z',
        );
        marker.value.setLatLng([pharmacy.lat.value, pharmacy.long.value]);
        map.value.flyTo([pharmacy.lat.value, pharmacy.long.value], 19);
    } else {
        pharmacy.description.value = '';
        pharmacy.name.value = "No s'ha trobat cap farmacia.";
    }
}

// Function Get Previous Month
function getPreviousMonth(): number {
    return idMonth.value - 1 < 0 ? 11 : idMonth.value - 1;
}
// Function Get Next Month
function getNextMonth(): number {
    return idMonth.value + 1 > 11 ? 0 : idMonth.value + 1;
}
// Function Set Previous Month
function setPreviousMonth() {
    idMonth.value = getPreviousMonth();
    if (idMonth.value === 11) {
        setPreviousYear();
    }
}
// Function Set Next Month
function setNextMonth() {
    idMonth.value = getNextMonth();
    if (idMonth.value === 0) {
        setNextYear();
    }
}
// Function Set Previous Year
function setPreviousYear() {
    numYear.value--;
}
// Function Set Next Year
function setNextYear() {
    numYear.value++;
}
// Function to Set Days
function setDays() {
    const maxDay = getMaxDay();
    let count = 0;
    for (const [, value] of Object.entries(week)) {
        value.value = selectedDay.value + count;
        if (value.value > maxDay) {
            value.value -= maxDay;
        }
        count++;
    }
}
// Function to Set Month Name
function setMonthName() {
    if (checkDoubleMonth()) {
        selectedMonth.value.name = `${nameMonth[idMonth.value]} - ${nameMonth[getNextMonth()]}`;
        selectedMonth.value.double = true;
    } else {
        selectedMonth.value.name = `${nameMonth[idMonth.value]}`;
        selectedMonth.value.double = false;
    }
}
// Check if has days from 2 months diferently set double name
function checkDoubleMonth(): boolean {
    return week.tue.value == 1 ||
        week.wed.value == 1 ||
        week.thu.value == 1 ||
        week.fri.value == 1 ||
        week.sat.value == 1 ||
        week.sun.value == 1
        ? true
        : false;
}

function getDayButtonClass(idWeek: number, day: number): string {
    const baseClass =
        'h-12 w-12 rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition';

    if (selectedWeekIndex.value === idWeek && selectedDay.value === day) {
        return `${baseClass} bg-[#01617F] text-white shadow-sm`;
    }

    return `${baseClass} bg-white text-[#1F2937] hover:bg-[#DDF3FB]`;
}
</script>

<template>
    <WebAppLayout>
        <section class="swiper bg-gray-800">
            <div class="swiper-wrapper">
                <img
                    src="/storage/slider1.jpeg"
                    class="swiper-slide object-cover"
                />
                <img
                    src="/storage/slider2.jpeg"
                    class="swiper-slide object-cover"
                />
            </div>
            <div class="swiper-pagination"></div>
        </section>

        <section
            id="qui-som"
            class="scroll-mt-24 bg-[#F2FAFF] px-2 py-12 md:px-24"
        >
            <Card class="flex-col bg-white md:flex-row">
                <div
                    class="flex h-110 w-full items-end overflow-hidden md:relative md:h-auto md:w-1/2"
                >
                    <img
                        src="/storage/farmaciaSolerStore.jpeg"
                        alt="Farmacia Soler"
                        class="h-full w-full rounded-xl object-cover object-bottom md:absolute"
                    />
                </div>
                <div
                    class="flex flex-col gap-4 px-8 py-8 md:h-160 md:w-1/2 md:py-16"
                >
                    <h2
                        class="text-center text-2xl font-bold md:text-left md:text-4xl"
                    >
                        ¿Quí som?
                    </h2>
                    <p>
                        Som la Farmàcia Soler de Figueres, ens trobem a la Font
                        lluminosa, Carrer Nou num. 22. Som una farmacia amb 80
                        anys d’història i amb més de 150 anys oberta. Actualment
                        som la 3a generació.
                    </p>
                </div>
            </Card>
        </section>

        <section
            id="farmacies-guardia"
            class="scroll-mt-24 bg-[#F2FAFF] px-2 pb-14 md:px-24"
        >
            <div class="mb-4">
                <h2
                    class="text-center text-3xl font-semibold text-[#124559] md:text-4xl"
                >
                    Farmàcies de guàrdia
                </h2>
                <p class="mt-2 text-center text-sm text-[#3B6A7A]">
                    Consulta la farmàcia de guàrdia per dia i obre la ubicació
                    al mapa.
                </p>
            </div>
            <Card
                class="flex-col overflow-hidden rounded-2xl border border-[#D0EAF3] shadow-lg shadow-[#01617F]/8"
            >
                <div
                    class="w-full rounded-t bg-gradient-to-r from-[#015873] to-[#01789E] px-4 py-5"
                >
                    <div class="text-white">
                        <p
                            class="text-center text-xs tracking-[0.16em] uppercase opacity-90"
                        >
                            {{ numYear }}
                        </p>
                        <h3 class="text-center text-2xl font-bold">
                            {{ selectedMonth.name }}
                        </h3>
                    </div>
                    <div class="mt-3 overflow-x-auto pb-1">
                        <div
                            class="mx-auto flex min-w-max items-end justify-center gap-2 text-black"
                        >
                            <!-- iconamoon:player-previous -->
                            <button
                                @click="setPreviousWeek()"
                                class="h-12 cursor-pointer rounded-lg px-1 hover:bg-white/10"
                            >
                                <Icon
                                    icon="iconamoon:player-play"
                                    class="rotate-180 text-[#C8F1FF]"
                                    width="24"
                                    height="24"
                                ></Icon>
                            </button>
                            <button
                                @click="setSelectDate(0, week.mon.value)"
                                :class="getDayButtonClass(0, week.mon.value)"
                            >
                                {{ week.mon }}
                            </button>
                            <button
                                @click="setSelectDate(1, week.tue.value)"
                                :class="getDayButtonClass(1, week.tue.value)"
                            >
                                {{ week.tue }}
                            </button>
                            <button
                                @click="setSelectDate(2, week.wed.value)"
                                :class="getDayButtonClass(2, week.wed.value)"
                            >
                                {{ week.wed }}
                            </button>
                            <button
                                @click="setSelectDate(3, week.thu.value)"
                                :class="getDayButtonClass(3, week.thu.value)"
                            >
                                {{ week.thu }}
                            </button>
                            <button
                                @click="setSelectDate(4, week.fri.value)"
                                :class="getDayButtonClass(4, week.fri.value)"
                            >
                                {{ week.fri }}
                            </button>
                            <button
                                @click="setSelectDate(5, week.sat.value)"
                                :class="getDayButtonClass(5, week.sat.value)"
                            >
                                {{ week.sat }}
                            </button>
                            <button
                                @click="setSelectDate(6, week.sun.value)"
                                :class="getDayButtonClass(6, week.sun.value)"
                            >
                                {{ week.sun }}
                            </button>
                            <button
                                @click="setNextWeek()"
                                class="h-12 cursor-pointer rounded-lg px-1 hover:bg-white/10"
                            >
                                <Icon
                                    icon="iconamoon:player-play"
                                    class="text-[#C8F1FF]"
                                    width="24"
                                    height="24"
                                ></Icon>
                            </button>
                            <!-- iconamoon:player-next -->
                        </div>
                    </div>
                </div>
                <div
                    class="flex w-full flex-col rounded-b bg-white md:flex-row"
                >
                    <div class="bg-[#E9F7FC] md:w-2/3">
                        <div id="map" class="z-0 h-100 w-full md:h-full"></div>
                    </div>
                    <div
                        class="border-[#D0EAF3] bg-[#E9F7FC] px-4 py-6 md:w-1/3 md:border-t-0 md:border-l md:p-6"
                    >
                        <h4
                            class="text-center text-2xl font-semibold text-[#0E3C4D] md:text-left"
                        >
                            {{ pharmacy.name || 'Carregant farmàcia...' }}
                        </h4>
                        <p
                            class="mt-3 rounded-lg border border-[#D8EEF6] bg-white/80 px-3 py-2 text-sm text-[#335B69]"
                        >
                            <span class="font-semibold">Data:</span>
                            {{ nameWeekDay[idWeekDay] }}, {{ selectedDay }}
                            {{ nameMonth[selectedMonth.num] }}
                            {{ selectedYear }}
                        </p>
                        <p
                            class="mt-3 min-h-12 text-sm leading-relaxed text-[#335B69]"
                        >
                            {{
                                pharmacy.description ||
                                'Sense informació addicional per aquest dia.'
                            }}
                        </p>
                        <a
                            id="address"
                            class="mt-5 inline-flex cursor-pointer rounded-lg bg-[#01617F] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#014F67]"
                            >Obrir direcció</a
                        >
                    </div>
                </div>
            </Card>
        </section>
    </WebAppLayout>
</template>
