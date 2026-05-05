<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import { Icon } from "@iconify/vue";
import { onMounted, ref } from 'vue';
import Card from '@/components/Card.vue';
import "leaflet";
import "leaflet/dist/leaflet.css";
import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';

const map = ref();
const marker = ref();

onMounted(() => {
    const date = new Date();

    selectedDay.value = date.getDate();
    idWeekDay.value = date.getDay()-1;
    idMonth.value = selectedMonth.value.num = date.getMonth();
    numYear.value = selectedYear.value = date.getFullYear();

    console.log(idMonth, selectedMonth, numYear, selectedYear)

    address.value = document.getElementById('address');
    address.value?.setAttribute('href', "https://www.google.com/maps/search@" + pharmacy.lat.value + "," + pharmacy.long.value + ",17z");

    const swiper = new Swiper(".swiper", {
        modules: [Pagination, Autoplay],
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: ".swiper-pagination",
        },
    });

    // Setup Map
    map.value = L.map('map').setView([pharmacy.lat.value, pharmacy.long.value], 19);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map.value);
    marker.value = L.marker([pharmacy.lat.value, pharmacy.long.value]).addTo(map.value);

    setDays();
    setMonthName();
    setSelectDate(idWeekDay.value, selectedDay.value);
});

const address = ref();

const pharmacy = {
    // Test Information
    name: ref('Farmacia Soler'),
    dia: ref(''),
    description: ref(''),
    lat: ref('42.2655267'),
    long: ref('2.9631527'),
};

// ID's
const selectedDay = ref();
const selectedYear = ref();
const idWeekDay = ref();
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
    'mon': ref(),
    'tue': ref(),
    'wed': ref(),
    'thu': ref(),
    'fri': ref(),
    'sat': ref(),
    'sun': ref(),
};
// Selected Month Info
const selectedMonth = ref({
    num: ref(),
    name: ref(''),
    double: false,
});

// Function get max day from month
function getMaxDay() : number {
    return new Date(numYear.value, idMonth.value+1, 0).getDate();
};

/// Buttons

// Button Select Day
function setSelectDate(idWeek : number, day : number) {
    selectedDay.value = day;
    idWeekDay.value = idWeek;
    selectedMonth.value.num = (selectedMonth.value.double && day < 7) ? getNextMonth() : idMonth.value;
    selectedYear.value = (selectedMonth.value.double && selectedMonth.value.num == 0) ? numYear.value + 1 : numYear.value;
    getPharmacyInfo(selectedDay.value, selectedMonth.value.num + 1, selectedYear.value);
}
// Button Previous Week
function setPreviousWeek() {
    if (week.mon.value < 7) {
        setPreviousMonth();
    };
    const limitDay = getMaxDay();
    for (const [key, value] of Object.entries(week)) {
        if ((value.value -= 7) < 1) {
            value.value += limitDay;
        };
        value.value == 1 ? setMonthName() : null;
    };
    if (selectedMonth.value.double || week.sun.value == limitDay) {
        setMonthName();
    };
};

// Button Next Week
function setNextWeek() {
    const limitDay = getMaxDay();
    for (const [key, value] of Object.entries(week)) {
        if ((value.value += 7) > limitDay)
        {
            if ((value.value -= limitDay) == 1) {
                setMonthName();
            };
        };
        if (value.value == 8 && selectedMonth.value.double) {
            setNextMonth();
            setMonthName();
        };
    };
    if (week.mon.value == 1 && week.sun.value == 7) {
        setNextMonth();
        setMonthName();
    }
};

/// Functions

// Function Get Pharmacy Info
async function getPharmacyInfo(day : number, month : number, year : number) {

    const reponse = await fetch(`/pharmacyguard/${year}-${month}-${day}`);
    
    const data = await reponse.json();
    
    if (data.success) {
        pharmacy.name.value = data.response.name;
        pharmacy.description.value = data.response.description;
        pharmacy.lat.value = data.response.latitude;
        pharmacy.long.value = data.response.longitude;
        console.log(data.response);

        address.value.setAttribute('href', "https://www.google.com/maps/@" + pharmacy.lat.value + "," + pharmacy.long.value + ",17z");
        marker.value.setLatLng([pharmacy.lat.value, pharmacy.long.value]);
        map.value.flyTo([pharmacy.lat.value, pharmacy.long.value], 19);
    } else {
        pharmacy.description.value = "";
        pharmacy.name.value = "No s'ha trobat cap farmacia."
    }
}

// Function Get Previous Month
function getPreviousMonth() : number {
    return idMonth.value - 1 < 0 ? 11 : idMonth.value - 1;
};
// Function Get Next Month
function getNextMonth() : number {
    return idMonth.value + 1 > 11 ? 0 : idMonth.value + 1;
};
// Function Set Previous Month
function setPreviousMonth() {
    idMonth.value = getPreviousMonth();
    idMonth.value == 11 ? setPreviousYear() : null;
};
// Function Set Next Month
function setNextMonth() {
    idMonth.value = getNextMonth();
    idMonth.value == 0 ? setNextYear() : null;
};
// Function Set Previous Year
function setPreviousYear() {
    numYear.value--;
};
// Function Set Next Year
function setNextYear() {
    numYear.value++;
};
// Function to Set Days
function setDays() {
    const maxDay = getMaxDay();
    let count = 0;
    for (const [key, value] of Object.entries(week)) {
        value.value = selectedDay.value - idWeekDay.value + count;
        if (value.value > maxDay) {
            value.value -= maxDay;
        }
        count++;
    }
};
// Function to Set Month Name
function setMonthName() {
    if (checkDoubleMonth()) {
        selectedMonth.value.name = `${nameMonth[idMonth.value]} - ${nameMonth[getNextMonth()]}`;
        selectedMonth.value.double = true;
    } else {
        selectedMonth.value.name = `${nameMonth[idMonth.value]}`;
        selectedMonth.value.double = false;
    }
};
// Check if has days from 2 months diferently set double name
function checkDoubleMonth() : boolean {
    return week.tue.value == 1 || week.wed.value == 1 || week.thu.value == 1 || week.fri.value == 1 || week.sat.value == 1 || week.sun.value == 1 ? true : false;
};
</script>

<template>
    <WebAppLayout>
        <section class="swiper bg-gray-800">
            <div class="swiper-wrapper">
                <img src="/storage/slider1.jpeg" class="swiper-slide object-cover"></img>
                <img src="/storage/slider2.jpeg" class="swiper-slide object-cover"></img>
            </div>
            <div class="swiper-pagination"></div>
        </section>

        <section class="bg-[#F2FAFF] py-12 px-2 md:px-24">
            <Card class="bg-white flex-col md:flex-row">
                <div class="md:relative h-110 md:h-auto w-full md:w-1/2 overflow-hidden flex items-end">
                    <img src="/storage/farmaciaSolerStore.jpeg"
                        alt="Farmacia Soler"
                        class="object-cover object-bottom w-full h-full md:absolute rounded-xl">
                </div>
                <div class="flex flex-col gap-4 px-8 py-8 md:w-1/2 md:py-16 md:h-160">
                    <h2 class="text-center text-2xl font-bold md:text-left md:text-4xl">¿Quí som?</h2>
                    <p>Som la Farmàcia Soler de Figueres, ens trobem a la Font lluminosa, Carrer Nou num. 22. Som una farmacia amb 80 anys d’història i amb més de 150 anys oberta. Actualment som la 3a generació.</p>
                </div>
            </Card>
        </section>

        <section class="bg-[#F2FAFF] pb-12 px-2 md:px-24 flex flex-col gap-4">
            <h2 class="text-center text-3xl">Farmaciés de Guardia</h2>
            <Card class="flex-col">
                <div class="bg-[#01617F] flex flex-col gap-2 py-4 rounded-t w-full">
                    <div class="text-white">
                        <p class="text-center text-sm font-bold">{{ numYear }}</p>
                        <h3 class="text-center text-2xl font-bold">{{ selectedMonth.name }}</h3>
                    </div>
                    <div class="flex items-end justify-center gap-2 text-black">
                        <!-- iconamoon:player-previous -->
                        <button @click="setPreviousWeek()" class="h-12 cursor-pointer"><Icon icon="iconamoon:player-play" class="text-[#9DDCF2] rotate-180" width="24" height="24"></Icon></button>
                        <button @click="setSelectDate(0, week.mon.value)" class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer">{{ week.mon }}</button>
                        <button @click="setSelectDate(1, week.tue.value)" class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer">{{ week.tue }}</button>
                        <button @click="setSelectDate(2, week.wed.value)" class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer">{{ week.wed }}</button>
                        <button @click="setSelectDate(3, week.thu.value)" class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer">{{ week.thu }}</button>
                        <button @click="setSelectDate(4, week.fri.value)" class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer">{{ week.fri }}</button>
                        <button @click="setSelectDate(5, week.sat.value)" class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer">{{ week.sat }}</button>
                        <button @click="setSelectDate(6, week.sun.value)" class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer">{{ week.sun }}</button>
                        <button @click="setNextWeek()" class="h-12 cursor-pointer"><Icon icon="iconamoon:player-play" class="text-[#9DDCF2]" width="24" height="24"></Icon></button>
                        <!-- iconamoon:player-next -->
                    </div>
                </div>
                <div class="bg-white flex flex-col md:flex-row rounded-b w-full">
                    <div class="md:w-2/3 bg-gray-200">
                        <div id="map" class="h-100 w-full z-0"></div>
                    </div>
                    <div class="md:w-1/3 md:p-2 py-6 px-4 bg-gray-200">
                        <h4 class="text-2xl text-center">{{ pharmacy.name }}</h4>
                        <p class="">Data: {{ nameWeekDay[idWeekDay] }}, {{ selectedDay }} {{ nameMonth[selectedMonth.num] }} {{ selectedYear }}</p>
                        <p class="">{{ pharmacy.description }}</p>
                        <a id="address" class="cursor-pointer rounded px-2 bg-violet-400">Obrir direcció</a>
                    </div>
                </div>
            </Card>
        </section>
    </WebAppLayout>
</template>