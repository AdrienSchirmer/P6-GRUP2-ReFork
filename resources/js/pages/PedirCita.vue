<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue'
import { ref, computed } from 'vue'
import { ScanFace, Droplet, FlaskConical, ShieldCheck, ChevronLeft, ChevronRight } from 'lucide-vue-next'
import { onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'

const today = new Date()

const todayYear = today.getFullYear()
const todayMonth = today.getMonth()
const todayDate = today.getDate()

const form = useForm<{
    service_id: number | null
    customer_name: string
    customer_phone: string
    customer_email: string
    appointment_date: string
    start_time: string
}>({
    service_id: null,
    customer_name: '',
    customer_phone: '',
    customer_email: '',
    appointment_date: '',
    start_time: '',
})
const selectedService = ref<number | null>(null)

onMounted(() => {
    if (props.services.length > 0) {
        selectedService.value = props.services[0].id
    }
})
const selectedServiceObj = computed(() =>
    props.services.find(s => s.id === selectedService.value)
)
defineOptions({
    layout: WebAppLayout
})
const props = defineProps<{
    services: Array<{
        id: number
        nom: string
        descripció: string
        durada: number | string
        icon: string
    }>
}>()
/*******************Steps********************************/
const step = ref(1)

function nextStep() {
    if (step.value < 3) step.value++
}

function prevStep() {
    if (step.value > 1) step.value--
}
/********************************************************/
const iconsMap: Record<string, any> = {
    ScanFace,
    Droplet,
    FlaskConical,
    ShieldCheck
}
const selectedTime = ref('10:30')
const selectedDate = ref<number | null>(todayDate)



// Calendar state
const currentYear = ref(todayYear)
const currentMonth = ref(todayMonth)
const monthNames = [
    'Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny',
    'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'
]

const dayHeaders = ['DL', 'DT', 'DC', 'DJ', 'DV', 'DS', 'DG']

const currentMonthLabel = computed(() =>
    `${monthNames[currentMonth.value]} ${currentYear.value}`
)

// Build calendar grid: array of { day: number|null, isCurrentMonth: boolean }
const calendarDays = computed(() => {
    const year = currentYear.value
    const month = currentMonth.value

    const firstDay = new Date(year, month, 1)
    const lastDay = new Date(year, month + 1, 0)
    const daysInMonth = lastDay.getDate()

    // getDay(): 0=Sun,1=Mon,...,6=Sat → convert to Mon-first: 0=Mon,...,6=Sun
    let startDow = firstDay.getDay()
    startDow = (startDow + 6) % 7

    const prevMonthLastDay = new Date(year, month, 0).getDate()

    const cells: { day: number; isCurrentMonth: boolean }[] = []

    // Previous month trailing days
    for (let i = startDow - 1; i >= 0; i--) {
        cells.push({ day: prevMonthLastDay - i, isCurrentMonth: false })
    }

    // Current month days
    for (let d = 1; d <= daysInMonth; d++) {
        cells.push({ day: d, isCurrentMonth: true })
    }

    // Next month leading days to fill 6 rows (42 cells)
    const remaining = 42 - cells.length
    for (let d = 1; d <= remaining; d++) {
        cells.push({ day: d, isCurrentMonth: false })
    }

    return cells
})

function prevMonth() {
    if (currentMonth.value === 0) {
        currentMonth.value = 11
        currentYear.value--
    } else {
        currentMonth.value--
    }
    selectedDate.value = null
}

function nextMonth() {
    if (currentMonth.value === 11) {
        currentMonth.value = 0
        currentYear.value++
    } else {
        currentMonth.value++
    }
    selectedDate.value = null
}

function selectDay(cell: { day: number; isCurrentMonth: boolean }) {
    if (!cell.isCurrentMonth) return

    const today = new Date()

    const isPast =
        currentYear.value === today.getFullYear() &&
        currentMonth.value === today.getMonth() &&
        cell.day < today.getDate()

    if (isPast) return

    selectedDate.value = cell.day
}

const availableTimes = [
    '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
    '12:00', '12:30', '13:00', '13:30', '16:00', '16:30',
    '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
]


/*Appointments store**/
function submitReservation() {
    form.service_id = selectedService.value
    form.customer_name = form.customer_name
    form.customer_phone = form.customer_phone
    form.customer_email = form.customer_email

    form.appointment_date = selectedDate.value
        ? `${currentYear.value}-${currentMonth.value + 1}-${selectedDate.value}`
        : ''

    form.start_time = selectedTime.value
    form.post('/appointments')
}
</script>

<template>
    <div class="bg-[#f3f4f6] text-slate-900">

        <!-- HERO -->
        <section class="py-10">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-8 items-center">

           
                <div>
                    <span
                        class="inline-block px-3 py-1 text-[10px] font-semibold tracking-widest uppercase bg-[#e5e7eb] text-[#8a6d1a] rounded-full mb-3">
                        CITA PRÈVIA A FIGUERES
                    </span>

                    <h1 class="text-2xl md:text-3xl font-bold text-[#0f5f7f] mb-3">
                        Demanar Cita
                    </h1>

                    <p class="text-sm text-slate-500 leading-relaxed max-w-md">
                        Reserva els nostres serveis clínics especialitzats amb la comoditat del sistema online.
                        La nostra centenària tradició a Figueres s'uneix a la tecnologia per oferir-te una atenció
                        farmacèutica d'avantguarda.
                    </p>
                </div>

              
                <div>
                    <div class="relative rounded-xl overflow-hidden shadow-md h-[180px] md:h-[220px]">
                        <img class="w-full h-full object-cover"
                            src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1400&auto=format&fit=crop"
                            alt="Consulta farmacèutica" />

                       
                        <div class="absolute inset-0 bg-[#0f5f7f]/10"></div>
                    </div>
                </div>

            </div>
        </section>

        <!-- BOOKING -->
        <section class="max-w-7xl mx-auto px-6 pb-20">
            <div class="bg-white rounded-3xl shadow-lg p-10">
                <div>

                    <!-- STEP 1: Service Selection -->

                    <div v-if="step === 1">
                        <div class="flex items-center gap-3 mb-8">
                            <span
                                class="w-8 h-8 rounded-full bg-[#0f5f7f] text-white flex items-center justify-center font-bold text-sm">1</span>
                            <h2 class="font-bold text-lg">Seleccionar Servei</h2>
                        </div>


                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div v-for="service in props.services" :key="service.id"
                                @click="selectedService = service.id" :class="[
                                    'p-4 rounded-xl cursor-pointer transition border',
                                    selectedService === service.id
                                        ? 'bg-[#dbeaf4] border-[#0f5f7f]'
                                        : 'bg-[#f3f4f6] border-transparent hover:border-[#9fbcd3]'
                                ]">
                                <div class="flex justify-between items-center mb-2">

                                    <!-- ICON -->
                                    <component :is="iconsMap[service.icon]" class="w-5 h-5 text-[#0f5f7f]" />

                                    <!-- DURATION -->
                                    <span class="text-xs font-semibold text-[#8a6d1a]">
                                        {{ service.durada }}
                                    </span>
                                </div>

                                <h3 class="font-bold text-base mb-1">
                                    {{ service.nom }}
                                </h3>

                                <p class="text-sm text-slate-600">
                                    {{ service.descripció }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- STEP 2: Date & Time -->
                    <div v-if="step === 2">
                        <div class="flex items-center gap-3 mb-8">
                            <span
                                class="w-8 h-8 rounded-full bg-[#0f5f7f] text-white flex items-center justify-center font-bold text-sm">2</span>
                            <h2 class="font-bold text-lg">Data i Hora</h2>
                        </div>

                       
                        <div class="grid md:grid-cols-2 gap-6 items-start">

                            <!-- CALENDAR -->
                            <div class="bg-[#f3f4f6] rounded-xl p-4">

                                <!-- Month navigation -->
                                <div class="flex items-center justify-between mb-3">
                                    <button @click="prevMonth"
                                        class="p-1.5 rounded-lg text-slate-500 hover:bg-white hover:text-[#0f5f7f] transition">
                                        <ChevronLeft class="w-5 h-5" />
                                    </button>

                                    <span class="font-semibold text-slate-700 text-sm">
                                        {{ currentMonthLabel }}
                                    </span>

                                    <button @click="nextMonth"
                                        class="p-1.5 rounded-lg text-slate-500 hover:bg-white hover:text-[#0f5f7f] transition">
                                        <ChevronRight class="w-5 h-5" />
                                    </button>
                                </div>

                                <!-- Days header -->
                                <div class="grid grid-cols-7 mb-2">
                                    <div v-for="h in dayHeaders" :key="h"
                                        class="text-center text-xs font-semibold text-slate-400 py-1">
                                        {{ h }}
                                    </div>
                                </div>

                                <!-- Calendar -->
                                <div class="grid grid-cols-7 gap-1">
                                    <button v-for="(cell, idx) in calendarDays" :key="idx" @click="selectDay(cell)"
                                        :disabled="!cell.isCurrentMonth" :class="[
                                            'flex items-center justify-center h-8 text-xs rounded-lg transition',
                                            !cell.isCurrentMonth
                                                ? 'text-slate-300'
                                                : selectedDate === cell.day
                                                    ? 'bg-[#0f5f7f] text-white font-semibold shadow-sm'
                                                    : 'text-slate-700 hover:bg-[#dbeaf4] hover:text-[#0f5f7f]'
                                        ]">
                                        {{ cell.day }}
                                    </button>
                                </div>

                            </div>

                            <!-- TIMES -->
                            <div>

                                <h4 class="text-xs font-bold text-slate-500 tracking-widest uppercase mb-3">
                                    Hores Disponibles
                                </h4>



                                <!-- Times grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <button v-for="time in availableTimes" :key="time" @click="selectedTime = time"
                                        :disabled="!selectedDate" :class="[
                                            'py-2 rounded-lg border text-xs font-medium transition',
                                            !selectedDate
                                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                                : selectedTime === time
                                                    ? 'bg-[#0f5f7f] text-white border-[#0f5f7f]'
                                                    : 'bg-white border-gray-200 text-slate-700 hover:border-[#0f5f7f]'
                                        ]">
                                        {{ time }}
                                    </button>
                                </div>



                            </div>

                        </div>
                    </div>


                    <!-- STEP 3: Personal Data -->
                    <div v-if="step === 3">

                        <div class="flex items-center gap-3 mb-8">
                            <span
                                class="w-8 h-8 rounded-full bg-[#0f5f7f] text-white flex items-center justify-center font-bold text-sm">3</span>
                            <h2 class="font-bold text-lg">Dades Personals</h2>
                        </div>

                        <!-- GRID -->
                        <div class="grid md:grid-cols-2 gap-6">

                            <!-- LEFT: FORM -->
                            <div class="space-y-4">

                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">
                                        Nom i Cognoms
                                    </label>
                                    <input v-model="form.customer_name" type="text" required
                                        class="w-full px-3 py-2.5 text-sm rounded-lg bg-[#f3f4f6] border border-transparent focus:bg-white focus:ring-2 focus:ring-[#0f5f7f] outline-none transition"
                                        placeholder="Nom i Cognoms" />
                                    <p v-if="form.errors.customer_name" class="text-red-500 text-xs mt-1">
                                        {{ form.errors.customer_name }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">
                                        Telèfon
                                    </label>
                                    <input v-model="form.customer_phone" type="tel" pattern="[0-9]{9}" maxlength="9"
                                        required
                                        class="w-full px-3 py-2.5 text-sm rounded-lg bg-[#f3f4f6] border border-transparent focus:bg-white focus:ring-2 focus:ring-[#0f5f7f] outline-none transition"
                                        placeholder="600 000 000" />
                                    <p v-if="form.errors.customer_phone" class="text-red-500 text-xs mt-1">
                                        {{ form.errors.customer_phone }}
                                    </p>

                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">
                                        Correu Electrònic
                                    </label>
                                    <input v-model="form.customer_email" type="email" required
                                        class="w-full px-3 py-2.5 text-sm rounded-lg bg-[#f3f4f6] border border-transparent focus:bg-white focus:ring-2 focus:ring-[#0f5f7f] outline-none transition"
                                        placeholder="exemple@mail.com" />
                                    <p v-if="form.errors.customer_email" class="text-red-500 text-xs mt-1">
                                        {{ form.errors.customer_email }}
                                    </p>
                                </div>

                            </div>

                            <!-- RIGHT: SUMMARY -->
                            <div class="space-y-4">

                                <!-- SUMMARY CARD -->
                                <div class="bg-[#f3f4f6] rounded-xl p-4 border border-[#e5e7eb]">

                                    <p class="text-sm font-semibold text-slate-800 mb-3">
                                        Resum de la reserva
                                    </p>

                                    <div class="space-y-2 text-sm text-slate-600">

                                        <div class="flex justify-between">
                                            <span>Servei</span>
                                            <span class="font-medium">
                                                {{ selectedServiceObj?.nom || '—' }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between">
                                            <span>Data</span>
                                            <span class="font-medium">
                                                {{ selectedDate ? `${selectedDate} ${monthNames[currentMonth]}
                                                ${currentYear}` : '—' }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between">
                                            <span>Hora</span>
                                            <span class="font-medium">
                                                {{ selectedTime }}
                                            </span>
                                        </div>

                                    </div>

                                </div>

                                <!-- INFO BOX -->
                                <!-----   <div
                                    class="bg-[#f5f1e6] border-l-4 border-[#8a6d1a] p-3 rounded-lg text-xs italic text-[#6b5010]">
                                    Recordi portar la seva Targeta de Soci Soler.
                                </div>------>

                                <!-- CONFIRM BUTTON -->
                                <button @click="submitReservation" :disabled="form.processing" class="w-full py-3 text-sm bg-[#0f5f7f] text-white rounded-lg font-semibold 
           hover:bg-[#0c4a63] active:scale-[0.98] transition-all shadow-md">
                                    {{ form.processing ? 'Confirmant...' : 'Confirmar Reserva' }}
                                </button>

                            </div>

                        </div>

                    </div>


                    <div class="flex justify-between items-center mt-8">


                        <button v-if="step > 1" @click="prevStep"
                            class="px-5 py-2.5 text-sm border border-[#0f5f7f] text-[#0f5f7f] rounded-lg font-medium hover:bg-[#e3f2f9] transition">
                            ← Enrere
                        </button>


                        <button v-if="step < 3" @click="nextStep" :disabled="step === 2 && !selectedDate"
                            class="ml-auto px-5 py-2.5 text-sm bg-[#0f5f7f] text-white rounded-lg font-medium hover:bg-[#0c4a63] disabled:opacity-50 transition">
                            Següent →
                        </button>

                    </div>

                </div>
            </div>
        </section>

    </div>
</template>