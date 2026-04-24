<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import { Icon } from "@iconify/vue";
import { onMounted, ref } from 'vue';
import Card from '@/components/Card.vue';

onMounted(() => {
    const date = new Date();
    numDay.value = date.getDate();
    idWeekDay.value = date.getDay()-1;
    idMonth.value = date.getMonth();
    numYear.value = date.getFullYear();

    address?.setAttribute('href', "https://www.google.com/maps/@" + pharmacy.lat.value + "," + pharmacy.long.value + ",17z");

    console.dir(address);

    setDays();
    setMonthName();
});

const address = document.getElementById('address');

const pharmacy = {
    // Test Information
    name: ref('Farmacia Soler'),
    dia: ref(''),
    description: ref(''),
    lat: ref('42.2635304'),
    long: ref('2.9576556'),
};

// ID's
const numDay = ref();
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
    name: ref(''),
    double: false,
});

// Function get max day from month
function getMaxDay() : number {
    return new Date(numYear.value, idMonth.value+1, 0).getDate();
};

/// Buttons

// Button Select Day
function setSelectDay(day : number) {
    getPharmacyInfo(day);
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
function getPharmacyInfo(day : number) {
    let formMonth = idMonth.value;
    let formYear = numYear.value;
    if (selectedMonth.value.double) {
        if (day < 7) {
            formMonth = getNextMonth();
            if (formMonth == 0) {
                formYear = numYear.value;
            }
        }
    }
    // --- The post request is missing ---
    // address?.setAttribute('href', "https://www.google.com/maps/@" + pharmacy.lat.value + "," + pharmacy.long.value + ",17z");
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
// Function Set Next Month2.9576556
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
    let count = 0;
    for (const [key, value] of Object.entries(week)) {
        value.value = numDay.value - idWeekDay.value + count;
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
       <div class="bg-[#F2FAFF] py-12 px-2 md:px-24">
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
                        <div class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer"><button @click="setSelectDay(week.mon.value)">{{ week.mon }}</button></div>
                        <div class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer"><button @click="setSelectDay(week.tue.value)">{{ week.tue }}</button></div>
                        <div class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer"><button @click="setSelectDay(week.wed.value)">{{ week.wed }}</button></div>
                        <div class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer"><button @click="setSelectDay(week.thu.value)">{{ week.thu }}</button></div>
                        <div class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer"><button @click="setSelectDay(week.fri.value)">{{ week.fri }}</button></div>
                        <div class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer"><button @click="setSelectDay(week.sat.value)">{{ week.sat }}</button></div>
                        <div class="h-12 w-12 bg-white rounded-xl text-center content-center cursor-pointer"><button @click="setSelectDay(week.sun.value)">{{ week.sun }}</button></div>
                        <button @click="setNextWeek()" class="h-12 cursor-pointer"><Icon icon="iconamoon:player-play" class="text-[#9DDCF2]" width="24" height="24"></Icon></button>
                        <!-- iconamoon:player-next -->
                    </div>
                </div>
                <div class="bg-white flex rounded-b w-full">
                    <div class="w-2/3 bg-gray-200">
                        <!-- Leaflet is missing -->
                        <div class="h-100 w-full bg-amber-200">
                            
                        </div>
                    </div>
                    <div class="w-1/3 p-2 bg-gray-200">
                        <h4 class="text-2xl text-center">{{ pharmacy.name }}</h4>
                        <p class="">Fecha: {{ nameWeekDay[idWeekDay] }}, {{ numDay }} {{ nameMonth[idMonth] }} {{ numYear }}</p>
                        <p class="">{{ pharmacy.description }}</p>
                        <a id="address" class="cursor-pointer rounded px-2 bg-violet-400">Obrir direcció</a>
                    </div>
                </div>
            </Card>
        </div>
    </WebAppLayout>
</template>