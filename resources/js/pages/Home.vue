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

    // Set Week
    selectedDate.week.value = date.getDay()-1;
    for (let i = 0; i < week.length; i++) {
        week[i].id.value = selectedDate.week.value + i < 7 ? selectedDate.week.value + i :  selectedDate.week.value - 7;
    };
    // Set Day
    selectedDate.day.value = date.getDate();
    setDays();
    // Set Month
    selectedDate.month.value = setMonth.num = date.getMonth();
    setMonthName();
    // Set Year
    selectedDate.year.value = setYear.num = date.getFullYear();
    setYearName();

    /// Leaflet
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

    getPharmacyInfo(selectedDate.day.value, setMonth.num + 1, selectedDate.year.value);
});

const address = ref();

const pharmacy = {
    name: ref(''),
    dia: ref(''),
    description: ref(''),
    lat: ref('42.2655267'),
    long: ref('2.9631527'),
};

// ID's
const selectedDate = {
    'week': ref(),
    'day': ref(),
    'month': ref(),
    'year': ref(),
}
// Actual Month Info
const setMonth = { num: 0, name: ref(''), double: false };
// Actual Year Info
const setYear = { num: 0, name: ref(''), double: false };

// Names
const nameWeekDay = [ 'Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres', 'Dissabte', 'Diumenge' ];
const nameMonth = [ 'Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny', 'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre' ];

// Set Week Days
const week = [
    { 'id': ref(), 'num': ref(), },
    { 'id': ref(), 'num': ref(), },
    { 'id': ref(), 'num': ref(), },
    { 'id': ref(), 'num': ref(), },
    { 'id': ref(), 'num': ref(), },
    { 'id': ref(), 'num': ref(), },
    { 'id': ref(), 'num': ref(), },
];

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
        marker.value.setLatLng([pharmacy.lat.value, pharmacy.long.value])
        map.value.flyTo([pharmacy.lat.value, pharmacy.long.value]);
    } else {
        pharmacy.description.value = "";
        pharmacy.name.value = "No s'ha trobat cap farmacia."
    }
}

/// Day

// Function Set Days
function setDays() {
    const maxDay = getMaxDay();
    let count = 0;
    for (let i = 0; i < week.length; i++) {
        week[i].num.value = selectedDate.day.value + count;
        if (week[i].num.value > maxDay) {
            week[i].num.value -= maxDay;
        }
        count++;
    }
};
// Function get max day from month
function getMaxDay() : number {
    return new Date(setYear.num, setMonth.num+1, 0).getDate();
};

/// Month

// Function Get Selected Month
function getSelectedMonth(day : number) : number {
    return setMonth.double && day < 7 ? getNextMonth() : setMonth.num;
}
// Function Set Month Name
function setMonthName() {
    if (checkDoubleMonth()) {
        setMonth.name.value = `${nameMonth[setMonth.num]} - ${nameMonth[getNextMonth()]}`;
        setMonth.double = true;
    } else {
        setMonth.name.value = `${nameMonth[setMonth.num]}`;
        setMonth.double = false;
    }
};
// Function Get Previous Month
function getPreviousMonth() : number {
    return setMonth.num - 1 < 0 ? 11 : setMonth.num - 1;
};
// Function Get Next Month
function getNextMonth() : number {
    return setMonth.num + 1 > 11 ? 0 : setMonth.num + 1;
};
// Function Set Previous Month
function setPreviousMonth() {
    setMonth.num = getPreviousMonth();
    setMonth.num == 11 ? setPreviousYear() : null;
};
// Function Set Next Month
function setNextMonth() {
    setMonth.num = getNextMonth();
    setMonth.num == 0 ? setNextYear() : null;
};

/// Year

// Function Get Selected Year
function getSelectedYear(day : number, month : number) : number {
    return setMonth.double && day < 7 && month == 0 ? setYear.num + 1 : setYear.num;
}
// Function Set Year Name
function setYearName() {
    if (checkDoubleYear()) {
        setYear.name.value = `${setYear.num} - ${setYear.num+1}`;
        setYear.double = true;
    } else {
        setYear.name.value = `${setYear.num}`;
        setYear.double = false;
    }
};
// Function Set Previous Year
function setPreviousYear() {
    setYear.num--;
    setYearName();
};
// Function Set Next Year
function setNextYear() {
    setYear.num++;
    setYearName();
};

/// Checks

// Check if has days from 2 months diferently set double name
function checkDoubleMonth() : boolean {
    for (let i = 0; i < week.length; i++) {
        if (week[i].num.value == 1 && i != 0) {
            return true;
        };
    };
    return false;
};
// Check if has months from 2 years diferently set double name
function checkDoubleYear() : boolean {
    if (checkDoubleMonth()) {
        if (setMonth.num == 11) return true;
    };
    return false;
};
// Check if week has date selected
function checkDateSelected() {
    for (let i = 0; i < week.length; i++) {
        const day = week[i].num.value;
        const month = getSelectedMonth(day);
        const year = getSelectedYear(day, month);
        day == selectedDate.day.value && month == selectedDate.month.value && year == selectedDate.year.value ? setButtonSelected(week[i].id.value) : false;
    };
};

/// Buttons

// Button Set Select Day
function setSelectDate(idWeek : number, day : number) {
    selectedDate.week.value = idWeek;
    selectedDate.day.value = day;
    selectedDate.month.value = getSelectedMonth(day);
    selectedDate.year.value = getSelectedYear(day, selectedDate.month.value);
    resetButtonColor();
    setButtonSelected(idWeek);
}

// Button Set Previous Week
function setPreviousWeek() {
    if (week[0].num.value < 8) {
        setPreviousMonth();
    };
    const limitDay = getMaxDay();
    for (let i = 0; i < week.length; i++) {
        if ((week[i].num.value -= 7) < 1) {
            week[i].num.value += limitDay;
        };
        if (week[i].num.value == 1)
        {
            setMonthName();
            if (checkDoubleYear()) {
                setYearName();
            }
        };
    };
    if (setMonth.double || week[6].num.value == limitDay) {
        setMonthName();
        if (setYear.double) setYearName(); 
    };
    resetButtonColor();
    checkDateSelected();
};
// Button Set Next Week
function setNextWeek() {
    const limitDay = getMaxDay();
    for (let i = 0; i < week.length; i++) {
        if ((week[i].num.value += 7) > limitDay)
        {
            if ((week[i].num.value -= limitDay) == 1) {
                setMonthName();
                setYearName();
            };
        };
        if (week[i].num.value == 8 && setMonth.double) {
            setNextMonth();
            setMonthName();
        };
    };
    if (week[0].num.value == 1) {
        setNextMonth();
        setMonthName();
    }
    resetButtonColor();
    checkDateSelected();
};

/// Button Color

// Set Button Color
function setButtonSelected(id : number) {
    const button = document.getElementById('week'+id);
    if (button) button.style.background = '#01617F';
}
// Reset All Button Color
function resetButtonColor() {
    for (let i = 0; i < week.length; i++) {
        const button = document.getElementById('week'+i);
        if (button) button.style.background = '';
    }
}
</script>

<template>
    <WebAppLayout>
        <section class="swiper bg-gray-800 h-[600px] w-full">
            <div class="swiper-wrapper">
                <img src="/storage/slider1.jpeg" class="swiper-slide object-cover"></img>
                <img src="/storage/slider2.jpeg" class="swiper-slide object-cover"></img>
            </div>
            <div class="swiper-pagination"></div>
        </section>

        <section class="bg-[#F2FAFF] py-12 px-2 md:px-24 scroll-mt-24">
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

        <section id="farmacies-guardia" class="bg-[#F2FAFF] px-2 pb-14 md:px-24 scroll-mt-24">
            <div class="mb-4">
                <h2 class="text-center text-3xl font-semibold text-[#124559] md:text-4xl">Farmàcies de guàrdia</h2>
                <p class="mt-2 text-center text-sm text-[#3B6A7A]">Consulta la farmàcia de guàrdia per dia i obre la ubicació al mapa.</p>
            </div>
            <Card class="flex-col overflow-hidden rounded-2xl border border-[#D0EAF3] shadow-lg shadow-[#01617F]/8">
                <div class="w-full rounded-t bg-gradient-to-r from-[#015873] to-[#01789E] px-4 py-5">
                    <div class="text-white">
                        <p class="text-center text-xs tracking-[0.16em] uppercase opacity-90">{{ setYear.name }}</p>
                        <h3 class="text-center text-2xl font-bold">{{ setMonth.name }}</h3>
                    </div>
                    <div class="mt-3 overflow-x-auto pb-1">
                        <div class="mx-auto flex min-w-max items-end justify-center gap-2 text-black">
                        <!-- iconamoon:player-previous -->
                        <button @click="setPreviousWeek()" class="h-12 cursor-pointer rounded-lg px-1 hover:bg-white/10"><Icon icon="iconamoon:player-play" class="text-[#C8F1FF] rotate-180" width="24" height="24"></Icon></button>
                        <button :id="'week'+week[0].id.value" @click="setSelectDate(week[0].id.value, week[0].num.value)" class="h-12 w-12 bg-white text-[#1F2937] hover:bg-[#DDF3FB] rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition">{{ week[0].num.value }}</button>
                        <button :id="'week'+week[1].id.value" @click="setSelectDate(week[1].id.value, week[1].num.value)" class="h-12 w-12 bg-white text-[#1F2937] hover:bg-[#DDF3FB] rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition">{{ week[1].num.value }}</button>
                        <button :id="'week'+week[2].id.value" @click="setSelectDate(week[2].id.value, week[2].num.value)" class="h-12 w-12 bg-white text-[#1F2937] hover:bg-[#DDF3FB] rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition">{{ week[2].num.value }}</button>
                        <button :id="'week'+week[3].id.value" @click="setSelectDate(week[3].id.value, week[3].num.value)" class="h-12 w-12 bg-white text-[#1F2937] hover:bg-[#DDF3FB] rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition">{{ week[3].num.value }}</button>
                        <button :id="'week'+week[4].id.value" @click="setSelectDate(week[4].id.value, week[4].num.value)" class="h-12 w-12 bg-white text-[#1F2937] hover:bg-[#DDF3FB] rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition">{{ week[4].num.value }}</button>
                        <button :id="'week'+week[5].id.value" @click="setSelectDate(week[5].id.value, week[5].num.value)" class="h-12 w-12 bg-white text-[#1F2937] hover:bg-[#DDF3FB] rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition">{{ week[5].num.value }}</button>
                        <button :id="'week'+week[6].id.value" @click="setSelectDate(week[6].id.value, week[6].num.value)" class="h-12 w-12 bg-white text-[#1F2937] hover:bg-[#DDF3FB] rounded-xl text-center content-center cursor-pointer text-sm font-semibold transition">{{ week[6].num.value }}</button>
                        <button @click="setNextWeek()" class="h-12 cursor-pointer rounded-lg px-1 hover:bg-white/10"><Icon icon="iconamoon:player-play" class="text-[#C8F1FF]" width="24" height="24"></Icon></button>
                        <!-- iconamoon:player-next -->
                        </div>
                    </div>
                </div>
                <div class="bg-white flex flex-col md:flex-row rounded-b w-full">
                    <div class="md:w-2/3 bg-[#E9F7FC]">
                        <div id="map" class="z-0 h-100 w-full md:h-full"></div>
                    </div>
                    <div class="border-[#D0EAF3] bg-[#E9F7FC] px-4 py-6 md:w-1/3 md:border-t-0 md:border-l md:p-6">
                        <h4 class="text-center text-2xl font-semibold text-[#0E3C4D] md:text-left">{{ pharmacy.name || "Carregant farmàcia..." }}</h4>
                        <p class="mt-3 rounded-lg bg-white/80 px-3 py-2 text-sm text-[#335B69] border border-[#D8EEF6]">
                            <span class="font-semibold">Data:</span>
                            {{ nameWeekDay[selectedDate.week.value] }}, {{ selectedDate.day.value }} {{ nameMonth[selectedDate.month.value] }} {{ selectedDate.year }}
                        </p>
                        <p class="mt-3 min-h-12 text-sm leading-relaxed text-[#335B69]">{{ pharmacy.description || "Sense informació addicional per aquest dia." }}</p>
                        <a id="address" class="mt-5 inline-flex cursor-pointer rounded-lg bg-[#01617F] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#014F67]">Obrir direcció</a>
                    </div>
                </div>
            </Card>
        </section>
    </WebAppLayout>
</template>
