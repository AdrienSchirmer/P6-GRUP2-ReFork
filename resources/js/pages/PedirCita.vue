<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import { ref, computed, onMounted, watch } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import {
    ScanFace,
    Droplet,
    FlaskConical,
    ShieldCheck,
    ChevronLeft,
    ChevronRight,
    Scissors,
    TestTube,
    Apple,
    Pill,
    HeartPulse,
} from 'lucide-vue-next';

defineOptions({
    layout: WebAppLayout,
});
const bookedTimes = ref<string[]>([]);

type ServiceItem = {
    id: number;
    nom: string;
    descripció: string;
    durada: number | string;
    icon: string;
};

type FlashSuccess = {
    message: string;
    service: number;
    date: string;
    time: string;
    name: string;
    email: string;
};

const props = defineProps<{
    services: ServiceItem[];
    turnstileSiteKey: string | null;
}>();

const page = usePage<{
    flash?: {
        success?: FlashSuccess;
    };
}>();

const showModal = ref(false);

const today = new Date();
const todayYear = today.getFullYear();
const todayMonth = today.getMonth();
const todayDate = today.getDate();

const form = useForm<{
    service_id: number | null;
    customer_name: string;
    customer_phone: string;
    customer_email: string;
    appointment_date: string;
    start_time: string;
    'cf-turnstile-response': string;
}>({
    service_id: null,
    customer_name: '',
    customer_phone: '',
    customer_email: '',
    appointment_date: '',
    start_time: '',
    'cf-turnstile-response': '',
});

const selectedService = ref<number | null>(null);
const selectedTime = ref('10:30');
const selectedDate = ref<number | null>(todayDate);

const step = ref(1);

const currentYear = ref(todayYear);
const currentMonth = ref(todayMonth);

const monthNames = [
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

const dayHeaders = ['DL', 'DT', 'DC', 'DJ', 'DV', 'DS', 'DG'];

const iconsMap: Record<string, any> = {
    ScanFace,
    Droplet,
    FlaskConical,
    ShieldCheck,
    ChevronLeft,
    ChevronRight,
    Scissors,
    TestTube,
    Apple,
    Pill,
    HeartPulse,
};

const successData = computed(() => page.props.flash?.success);

const selectedServiceObj = computed(() =>
    props.services.find((s) => s.id === selectedService.value),
);

const successServiceName = computed(() => {
    if (!successData.value?.service) return '—';
    return (
        props.services.find((s) => s.id === successData.value?.service)?.nom ??
        '—'
    );
});

const currentMonthLabel = computed(
    () => `${monthNames[currentMonth.value]} ${currentYear.value}`,
);

const calendarDays = computed(() => {
    const year = currentYear.value;
    const month = currentMonth.value;

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();

    let startDow = firstDay.getDay();
    startDow = (startDow + 6) % 7;

    const prevMonthLastDay = new Date(year, month, 0).getDate();

    const cells: { day: number; isCurrentMonth: boolean }[] = [];

    for (let i = startDow - 1; i >= 0; i--) {
        cells.push({ day: prevMonthLastDay - i, isCurrentMonth: false });
    }

    for (let d = 1; d <= daysInMonth; d++) {
        cells.push({ day: d, isCurrentMonth: true });
    }

    const remaining = 42 - cells.length;
    for (let d = 1; d <= remaining; d++) {
        cells.push({ day: d, isCurrentMonth: false });
    }

    return cells;
});

const availableTimes = [
    '09:00',
    '09:30',
    '10:00',
    '10:30',
    '11:00',
    '11:30',
    '12:00',
    '12:30',
    '13:00',
    '13:30',
    '16:00',
    '16:30',
    '17:00',
    '17:30',
    '18:00',
    '18:30',
    '19:00',
    '19:30',
];

// Build PDF download URL from flash data
const pdfDownloadUrl = computed(() => {
    if (!successData.value) return '#';
    const params = new URLSearchParams({
        service: String(successData.value.service),
        date: successData.value.date,
        time: successData.value.time,
        name: successData.value.name,
        email: successData.value.email,
    });
    return `/appointments/pdf?${params.toString()}`;
});

// Watch flash
watch(
    () => page.props.flash?.success,
    (val) => {
        if (val) {
            showModal.value = true;
            step.value = 1;
            form.reset();
            selectedDate.value = todayDate;
            selectedTime.value = '10:30';
        }
    },
    { immediate: true },
);

onMounted(async () => {
    if (props.services.length > 0) {
        selectedService.value = props.services[0].id;
    }

    await fetchBookedTimes();
});

function nextStep() {
    if (step.value < 3) step.value++;

    if (step.value === 3) {
        if (
            !props.turnstileSiteKey ||
            document.getElementById('cf-turnstile-api')
        )
            return;
        const s = document.createElement('script');
        s.id = 'cf-turnstile-api';
        s.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
        s.async = true;
        s.defer = true;
        document.head.appendChild(s);
    }
}

function prevStep() {
    if (step.value > 1) step.value--;
}

function prevMonth() {
    const isCurrentRealMonth =
        currentYear.value === todayYear && currentMonth.value === todayMonth;
    if (isCurrentRealMonth) return;
    if (currentMonth.value === 0) {
        currentMonth.value = 11;
        currentYear.value--;
    } else {
        currentMonth.value--;
    }
    selectedDate.value = null;
}

function nextMonth() {
    if (currentMonth.value === 11) {
        currentMonth.value = 0;
        currentYear.value++;
    } else {
        currentMonth.value++;
    }
    selectedDate.value = null;
}

function selectDay(cell: { day: number; isCurrentMonth: boolean }) {
    if (!cell.isCurrentMonth) return;
    const isPast =
        currentYear.value === todayYear &&
        currentMonth.value === todayMonth &&
        cell.day < todayDate;
    if (isPast) return;
    selectedDate.value = cell.day;
}

function submitReservation() {
    form.service_id = selectedService.value;
    form.appointment_date = selectedDate.value
        ? `${currentYear.value}-${String(currentMonth.value + 1).padStart(2, '0')}-${String(selectedDate.value).padStart(2, '0')}`
        : '';
    form.start_time = selectedTime.value;
    form['cf-turnstile-response'] =
        (
            document.querySelector(
                'input[name="cf-turnstile-response"]',
            ) as HTMLInputElement | null
        )?.value ?? '';
    form.post('/appointments');
}

function goToDashboard() {
    router.visit('/dashboard');
}
/********************   */
async function fetchBookedTimes() {
    if (!selectedDate.value || !selectedService.value) {
        bookedTimes.value = [];
        return;
    }

    const date = `${currentYear.value}-${String(currentMonth.value + 1).padStart(2, '0')}-${String(selectedDate.value).padStart(2, '0')}`;

    const response = await fetch(
        `/appointments/booked-times?date=${date}&service_id=${selectedService.value}`,
    );
    bookedTimes.value = await response.json();
}

watch([selectedDate, selectedService, currentMonth, currentYear], () => {
    fetchBookedTimes();
});
</script>

<template>
    <div class="bg-[#f3f4f6] text-slate-900">
        <section class="py-10">
            <div
                class="mx-auto grid max-w-6xl items-center gap-8 px-6 md:grid-cols-2"
            >
                <div>
                    <span
                        class="mb-3 inline-block rounded-full bg-[#e5e7eb] px-3 py-1 text-[10px] font-semibold tracking-widest text-[#8a6d1a] uppercase"
                    >
                        CITA PRÈVIA A FIGUERES
                    </span>

                    <h1
                        class="mb-3 text-2xl font-bold text-[#0f5f7f] md:text-3xl"
                    >
                        Demanar Cita
                    </h1>

                    <p class="max-w-md text-sm leading-relaxed text-slate-500">
                        Reserva els nostres serveis clínics especialitzats amb
                        la comoditat del sistema online. La nostra centenària
                        tradició a Figueres s'uneix a la tecnologia per
                        oferir-te una atenció farmacèutica d'avantguarda.
                    </p>
                </div>

                <div>
                    <div
                        class="relative h-[180px] overflow-hidden rounded-xl shadow-md md:h-[220px]"
                    >
                        <img
                            class="h-full w-full object-cover"
                            src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1400&auto=format&fit=crop"
                            alt="Consulta farmacèutica"
                        />
                        <div class="absolute inset-0 bg-[#0f5f7f]/10"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-6 pb-20">
            <div class="rounded-3xl bg-white p-10 shadow-lg">
                <div>
                    <div v-show="step === 1">
                        <div class="mb-8 flex items-center gap-3">
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-[#0f5f7f] text-sm font-bold text-white"
                                >1</span
                            >
                            <h2 class="text-lg font-bold">
                                Seleccionar Servei
                            </h2>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div
                                v-for="service in props.services"
                                :key="service.id"
                                @click="selectedService = service.id"
                                :class="[
                                    'cursor-pointer rounded-xl border p-4 transition',
                                    selectedService === service.id
                                        ? 'border-[#0f5f7f] bg-[#dbeaf4]'
                                        : 'border-transparent bg-[#f3f4f6] hover:border-[#9fbcd3]',
                                ]"
                            >
                                <div
                                    class="mb-2 flex items-center justify-between"
                                >
                                    <component
                                        :is="iconsMap[service.icon] || 'Plus'"
                                        class="h-5 w-5 text-[#0f5f7f]"
                                    />
                                    <span
                                        class="text-xs font-semibold text-[#8a6d1a]"
                                    >
                                        {{ service.durada }}
                                    </span>
                                </div>
                                <h3 class="mb-1 text-base font-bold">
                                    {{ service.nom }}
                                </h3>
                                <p class="text-sm text-slate-600">
                                    {{ service.descripció }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Date & Time -->
                    <div v-show="step === 2">
                        <div class="mb-8 flex items-center gap-3">
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-[#0f5f7f] text-sm font-bold text-white"
                                >2</span
                            >
                            <h2 class="text-lg font-bold">Data i Hora</h2>
                        </div>

                        <div class="grid items-start gap-6 md:grid-cols-2">
                            <div class="rounded-xl bg-[#f3f4f6] p-4">
                                <div
                                    class="mb-3 flex items-center justify-between"
                                >
                                    <button
                                        @click="prevMonth"
                                        class="rounded-lg p-1.5 text-slate-500 transition hover:bg-white hover:text-[#0f5f7f]"
                                    >
                                        <ChevronLeft class="h-5 w-5" />
                                    </button>
                                    <span
                                        class="text-sm font-semibold text-slate-700"
                                        >{{ currentMonthLabel }}</span
                                    >
                                    <button
                                        @click="nextMonth"
                                        class="rounded-lg p-1.5 text-slate-500 transition hover:bg-white hover:text-[#0f5f7f]"
                                    >
                                        <ChevronRight class="h-5 w-5" />
                                    </button>
                                </div>

                                <div class="mb-2 grid grid-cols-7">
                                    <div
                                        v-for="h in dayHeaders"
                                        :key="h"
                                        class="py-1 text-center text-xs font-semibold text-slate-400"
                                    >
                                        {{ h }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-7 gap-1">
                                    <button
                                        v-for="(cell, idx) in calendarDays"
                                        :key="idx"
                                        @click="selectDay(cell)"
                                        :disabled="!cell.isCurrentMonth"
                                        :class="[
                                            'flex h-8 items-center justify-center rounded-lg text-xs transition',
                                            !cell.isCurrentMonth
                                                ? 'text-slate-300'
                                                : selectedDate === cell.day
                                                  ? 'bg-[#0f5f7f] font-semibold text-white shadow-sm'
                                                  : 'text-slate-700 hover:bg-[#dbeaf4] hover:text-[#0f5f7f]',
                                        ]"
                                    >
                                        {{ cell.day }}
                                    </button>
                                </div>
                            </div>

                            <div>
                                <h4
                                    class="mb-3 text-xs font-bold tracking-widest text-slate-500 uppercase"
                                >
                                    Hores Disponibles
                                </h4>
                                <div
                                    class="grid grid-cols-2 gap-2 sm:grid-cols-3"
                                >
                                    <button
                                        v-for="time in availableTimes"
                                        :key="time"
                                        @click="selectedTime = time"
                                        :disabled="
                                            !selectedDate ||
                                            bookedTimes.includes(time)
                                        "
                                        :class="[
                                            'rounded-lg border py-2 text-xs font-medium transition',

                                            !selectedDate
                                                ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                                                : bookedTimes.includes(time)
                                                  ? 'cursor-not-allowed border-red-300 bg-red-100 text-red-500'
                                                  : selectedTime === time
                                                    ? 'border-[#0f5f7f] bg-[#0f5f7f] text-white'
                                                    : 'border-gray-200 bg-white text-slate-700 hover:border-[#0f5f7f]',
                                        ]"
                                    >
                                        {{ time }}
                                    </button>
                                </div>
                                <p
                                    v-if="form.errors.start_time"
                                    class="mt-2 text-xs text-red-500"
                                >
                                    {{ form.errors.start_time }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Personal Data -->
                    <div v-show="step === 3">
                        <div class="mb-8 flex items-center gap-3">
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-[#0f5f7f] text-sm font-bold text-white"
                                >3</span
                            >
                            <h2 class="text-lg font-bold">Dades Personals</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-semibold text-slate-500"
                                        >Nom i Cognoms</label
                                    >
                                    <input
                                        v-model="form.customer_name"
                                        type="text"
                                        required
                                        class="w-full rounded-lg border border-transparent bg-[#f3f4f6] px-3 py-2.5 text-sm transition outline-none focus:bg-white focus:ring-2 focus:ring-[#0f5f7f]"
                                        placeholder="Nom i Cognoms"
                                    />
                                    <p
                                        v-if="form.errors.customer_name"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors.customer_name }}
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="mb-1 block text-xs font-semibold text-slate-500"
                                        >Telèfon</label
                                    >
                                    <input
                                        v-model="form.customer_phone"
                                        type="tel"
                                        pattern="[0-9]{9}"
                                        maxlength="9"
                                        required
                                        class="w-full rounded-lg border border-transparent bg-[#f3f4f6] px-3 py-2.5 text-sm transition outline-none focus:bg-white focus:ring-2 focus:ring-[#0f5f7f]"
                                        placeholder="600 000 000"
                                    />
                                    <p
                                        v-if="form.errors.customer_phone"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors.customer_phone }}
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="mb-1 block text-xs font-semibold text-slate-500"
                                        >Correu Electrònic</label
                                    >
                                    <input
                                        v-model="form.customer_email"
                                        type="email"
                                        required
                                        class="w-full rounded-lg border border-transparent bg-[#f3f4f6] px-3 py-2.5 text-sm transition outline-none focus:bg-white focus:ring-2 focus:ring-[#0f5f7f]"
                                        placeholder="exemple@mail.com"
                                    />
                                    <p
                                        v-if="form.errors.customer_email"
                                        class="mt-1 text-xs text-red-500"
                                    >
                                        {{ form.errors.customer_email }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div
                                    class="rounded-xl border border-[#e5e7eb] bg-[#f3f4f6] p-4"
                                >
                                    <p
                                        class="mb-3 text-sm font-semibold text-slate-800"
                                    >
                                        Resum de la reserva
                                    </p>
                                    <div
                                        class="space-y-2 text-sm text-slate-600"
                                    >
                                        <div class="flex justify-between">
                                            <span>Servei</span>
                                            <span class="font-medium">{{
                                                selectedServiceObj?.nom || '—'
                                            }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Data</span>
                                            <span class="font-medium">
                                                {{
                                                    selectedDate
                                                        ? `${selectedDate} ${monthNames[currentMonth]}
                                                ${currentYear}`
                                                        : '—'
                                                }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Hora</span>
                                            <span class="font-medium">{{
                                                selectedTime
                                            }}</span>
                                        </div>
                                    </div>
                                </div>

                                <button
                                    @click="submitReservation"
                                    :disabled="form.processing"
                                    class="w-full rounded-lg bg-[#0f5f7f] py-3 text-sm font-semibold text-white shadow-md transition-all hover:bg-[#0c4a63] active:scale-[0.98]"
                                >
                                    {{
                                        form.processing
                                            ? 'Confirmant...'
                                            : 'Confirmar Reserva'
                                    }}
                                </button>
                                <div v-if="props.turnstileSiteKey" class="pt-2">
                                    <div
                                        class="cf-turnstile"
                                        :data-sitekey="props.turnstileSiteKey"
                                        data-language="es"
                                    ></div>
                                    <p
                                        v-if="
                                            form.errors['cf-turnstile-response']
                                        "
                                        class="mt-2 text-sm text-red-600"
                                    >
                                        {{
                                            form.errors['cf-turnstile-response']
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-8 flex items-center justify-between">
                        <button
                            v-if="step > 1"
                            @click="prevStep"
                            class="rounded-lg border border-[#0f5f7f] px-5 py-2.5 text-sm font-medium text-[#0f5f7f] transition hover:bg-[#e3f2f9]"
                        >
                            ← Enrere
                        </button>
                        <button
                            v-if="step < 3"
                            @click="nextStep"
                            :disabled="step === 2 && !selectedDate"
                            class="ml-auto rounded-lg bg-[#0f5f7f] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#0c4a63] disabled:opacity-50"
                        >
                            Següent →
                        </button>
                    </div>
                </div>
            </div>

            <!--  Success Confirmation Modal -->
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60"
            >
                <div class="relative w-full max-w-md p-4">
                    <div class="rounded-lg bg-white p-6 shadow-xl">
                        <!-- Header -->
                        <div
                            class="flex items-center justify-between border-b pb-4"
                        >
                            <h3 class="text-lg font-semibold text-[#0f5f7f]">
                                Reserva confirmada
                            </h3>
                            <button
                                @click="showModal = false"
                                class="text-gray-400 transition hover:text-black"
                            >
                                ✕
                            </button>
                        </div>

                        <!-- Success message -->
                        <div class="pt-4 pb-3">
                            <p class="text-sm font-medium text-green-600">
                                {{ successData?.message }}
                            </p>
                        </div>

                        <!-- Booking + client summary -->
                        <div
                            class="mb-4 space-y-2 rounded-lg bg-gray-100 p-3 text-xs"
                        >
                            <div class="flex justify-between">
                                <span class="text-gray-500">Servei</span>
                                <span class="font-semibold text-gray-800">{{
                                    successServiceName
                                }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Data</span>
                                <span class="font-semibold text-gray-800">{{
                                    successData?.date
                                }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Hora</span>
                                <span class="font-semibold text-gray-800">{{
                                    successData?.time
                                }}</span>
                            </div>
                            <!-- Client info separator -->
                            <div
                                class="mt-1 space-y-2 border-t border-gray-300 pt-2"
                            >
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Nom</span>
                                    <span class="font-semibold text-gray-800">{{
                                        successData?.name
                                    }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Correu</span>
                                    <span
                                        class="max-w-[200px] truncate font-semibold text-gray-800"
                                        >{{ successData?.email }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Captcha 
                        <div
                            class="mb-4 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center h-[78px]">

                            <div class="text-center">
                                <p class="text-xs text-gray-400 font-medium">[ CAPTCHA ]</p>
                                <p class="text-[10px] text-gray-300">El meu captcha </p>
                            </div>
                        </div>
-->
                        <!-- Action buttons -->
                        <div class="flex gap-3">
                            <!-- Download PDF -->
                            <a
                                :href="pdfDownloadUrl"
                                target="_blank"
                                class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-[#0f5f7f] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[#0c4a63]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 shrink-0"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                    />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Descarregar PDF
                            </a>

                            <!-- Close -->
                            <button @click="showModal = false; router.visit('/')"
                                class="flex-1 border border-gray-300 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-400 transition">
                                Tancar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
