<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue'
import { ref, computed } from 'vue'
import { ScanFace, Droplet, FlaskConical, ShieldCheck, ChevronLeft, ChevronRight } from 'lucide-vue-next'

defineOptions({
    layout: WebAppLayout
})

const selectedService = ref('dermo')
const selectedTime = ref('10:30')
const selectedDate = ref<number | null>(3)

// Calendar state
const currentYear = ref(2024)
const currentMonth = ref(9) 
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
    selectedDate.value = cell.day
}

const availableTimes = [
    '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
    '12:00', '12:30', '13:00', '13:30', '16:00', '16:30',
    '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
]
</script>

<template>
    <div class="bg-[#f3f4f6] text-slate-900">

        <!-- HERO -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <span
                        class="inline-block px-4 py-1 text-xs font-semibold tracking-widest uppercase bg-[#e5e7eb] text-[#8a6d1a] rounded-full mb-6">
                        CITA PRÈVIA A FIGUERES
                    </span>
                    <h1 class="text-5xl md:text-6xl font-extrabold text-[#0f5f7f] mb-6">
                        Demanar Cita
                    </h1>
                    <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
                        Reserva els nostres serveis clínics especialitzats amb la comoditat del sistema online.
                        La nostra centenària tradició a Figueres s'uneix a la tecnologia per oferir-te una atenció
                        farmacèutica d'avantguarda.
                    </p>
                </div>
                <div>
                    <div class="rounded-3xl overflow-hidden shadow-xl">
                        <img class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuABratlbd2xFNslHSi_FOXZJNLl9PNcF1X_LAIqix2i1aR27eBij9L26OnzzQY-uFmeRzorlBi-E4t379X6rE77OQCdjcdJerupEzLS6zL2C8KDU8u5XLY8X6Clwy2ri6bBWb8_qnZXlQh6v2y-02vX4XCCT0RdnJqzgUnn0JUa5b15RhJIv7CiAGUUqrydkpmlwTgPtj0IvznMWiDZthB8HURhdOwnKMYp73CTzM0GzS3Ph2UcIs3huv48oJQLEFAL-2JP3sCI14"
                            alt="pharmacy" />
                    </div>
                </div>
            </div>
        </section>

        <!-- BOOKING -->
        <section class="max-w-7xl mx-auto px-6 pb-20">
            <div class="bg-white rounded-3xl shadow-lg p-10">
                <div class="grid lg:grid-cols-3 gap-12">

                    <!-- STEP 1: Service Selection -->
                    <div>
                        <div class="flex items-center gap-3 mb-8">
                            <span
                                class="w-8 h-8 rounded-full bg-[#0f5f7f] text-white flex items-center justify-center font-bold text-sm">1</span>
                            <h2 class="font-bold text-lg">Seleccionar Servei</h2>
                        </div>

                        <div class="space-y-4">
                            <!-- Card 1 -->
                            <div @click="selectedService = 'dermo'" :class="[
                                'p-5 rounded-2xl cursor-pointer transition border-2',
                                selectedService === 'dermo'
                                    ? 'bg-[#dbeaf4] border-[#0f5f7f]'
                                    : 'bg-[#f3f4f6] border-transparent hover:border-[#9fbcd3]'
                            ]">
                                <div class="flex justify-between items-center mb-2">
                                    <ScanFace class="w-5 h-5 text-[#0f5f7f]" />
                                    <span class="text-xs font-semibold text-[#8a6d1a]">30 min</span>
                                </div>
                                <h3 class="font-bold text-base mb-1">Dermoanàlisi Facial</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">Estudi detallat de la teva pell amb tecnologia d'última generació.</p>
                            </div>

                            <!-- Card 2 -->
                            <div @click="selectedService = 'aigua'" :class="[
                                'p-5 rounded-2xl cursor-pointer transition border-2',
                                selectedService === 'aigua'
                                    ? 'bg-[#dbeaf4] border-[#0f5f7f]'
                                    : 'bg-[#f3f4f6] border-transparent hover:border-[#9fbcd3]'
                            ]">
                                <div class="flex justify-between items-center mb-2">
                                    <Droplet class="w-5 h-5 text-[#0f5f7f]" />
                                    <span class="text-xs font-semibold text-[#8a6d1a]">15 min</span>
                                </div>
                                <h3 class="font-bold text-base mb-1">Anàlisi d'aigües</h3>
                                <p class="text-sm text-slate-600">Control de qualitat físic-químic i microbiològic per a consum.</p>
                            </div>

                            <!-- Card 3 -->
                            <div @click="selectedService = 'formula'" :class="[
                                'p-5 rounded-2xl cursor-pointer transition border-2',
                                selectedService === 'formula'
                                    ? 'bg-[#dbeaf4] border-[#0f5f7f]'
                                    : 'bg-[#f3f4f6] border-transparent hover:border-[#9fbcd3]'
                            ]">
                                <div class="flex justify-between items-center mb-2">
                                    <FlaskConical class="w-5 h-5 text-[#0f5f7f]" />
                                    <span class="text-xs font-semibold text-[#8a6d1a]">Varis</span>
                                </div>
                                <h3 class="font-bold text-base mb-1">Fórmula Magistral</h3>
                                <p class="text-sm text-slate-600">Medicació personalitzada segons prescripció mèdica específica.</p>
                            </div>

                            <!-- Card 4 -->
                            <div @click="selectedService = 'seguiment'" :class="[
                                'p-5 rounded-2xl cursor-pointer transition border-2',
                                selectedService === 'seguiment'
                                    ? 'bg-[#dbeaf4] border-[#0f5f7f]'
                                    : 'bg-[#f3f4f6] border-transparent hover:border-[#9fbcd3]'
                            ]">
                                <div class="flex justify-between items-center mb-2">
                                    <ShieldCheck class="w-5 h-5 text-[#0f5f7f]" />
                                    <span class="text-xs font-semibold text-[#8a6d1a]">45 min</span>
                                </div>
                                <h3 class="font-bold text-base mb-1">Seguiment Farmacèutic</h3>
                                <p class="text-sm text-slate-600">Gestió del pla de medicació per millorar l'adherència al tractament.</p>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Date & Time -->
                    <div>
                        <div class="flex items-center gap-3 mb-8">
                            <span
                                class="w-8 h-8 rounded-full bg-[#0f5f7f] text-white flex items-center justify-center font-bold text-sm">2</span>
                            <h2 class="font-bold text-lg">Data i Hora</h2>
                        </div>

                        <!-- Flowbite-style Calendar -->
                        <div class="bg-[#f3f4f6] rounded-2xl p-5 mb-6">
                            <!-- Month navigation -->
                            <div class="flex items-center justify-between mb-4">
                                <button
                                    @click="prevMonth"
                                    class="p-1.5 rounded-lg text-slate-500 hover:bg-white hover:text-[#0f5f7f] transition"
                                    aria-label="Mes anterior">
                                    <ChevronLeft class="w-5 h-5" />
                                </button>

                                <span class="font-bold text-slate-800 text-sm">{{ currentMonthLabel }}</span>

                                <button
                                    @click="nextMonth"
                                    class="p-1.5 rounded-lg text-slate-500 hover:bg-white hover:text-[#0f5f7f] transition"
                                    aria-label="Mes següent">
                                    <ChevronRight class="w-5 h-5" />
                                </button>
                            </div>

                            <!-- Day headers -->
                            <div class="grid grid-cols-7 mb-2">
                                <div
                                    v-for="h in dayHeaders"
                                    :key="h"
                                    class="text-center text-xs font-semibold text-slate-400 py-1">
                                    {{ h }}
                                </div>
                            </div>

                            <!-- Calendar grid -->
                            <div class="grid grid-cols-7 gap-y-1">
                                <button
                                    v-for="(cell, idx) in calendarDays"
                                    :key="idx"
                                    @click="selectDay(cell)"
                                    :disabled="!cell.isCurrentMonth"
                                    :class="[
                                        'flex items-center justify-center h-8 w-full rounded-lg text-sm transition',
                                        !cell.isCurrentMonth
                                            ? 'text-slate-300 cursor-default'
                                            : selectedDate === cell.day
                                                ? 'bg-[#0f5f7f] text-white font-bold'
                                                : 'text-slate-700 hover:bg-[#dbeaf4] hover:text-[#0f5f7f] cursor-pointer'
                                    ]">
                                    {{ cell.day }}
                                </button>
                            </div>
                        </div>

                        <!-- Available times -->
                        <h4 class="text-xs font-bold text-slate-500 tracking-widest uppercase mb-3">Hores Disponibles</h4>
                        <div class="grid grid-cols-3 gap-2">
                            <button
                                v-for="time in availableTimes"
                                :key="time"
                                @click="selectedTime = time"
                                :class="[
                                    'py-2.5 px-1 rounded-xl border text-sm font-medium transition',
                                    selectedTime === time
                                        ? 'bg-[#dbeaf4] border-[#0f5f7f] text-[#0f5f7f] font-bold'
                                        : 'border-gray-200 bg-white text-slate-700 hover:bg-gray-50 hover:border-[#9fbcd3]'
                                ]">
                                {{ time }}
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: Personal Data -->
                    <div>
                        <div class="flex items-center gap-3 mb-8">
                            <span
                                class="w-8 h-8 rounded-full bg-[#0f5f7f] text-white flex items-center justify-center font-bold text-sm">3</span>
                            <h2 class="font-bold text-lg">Dades Personals</h2>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nom i Cognoms</label>
                                <input
                                    type="text"
                                    class="w-full p-4 rounded-xl bg-[#f3f4f6] border border-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0f5f7f] focus:border-transparent transition placeholder:text-slate-400 text-slate-800"
                                    placeholder="Escriu el teu nom complet" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Telèfon</label>
                                <input
                                    type="tel"
                                    class="w-full p-4 rounded-xl bg-[#f3f4f6] border border-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0f5f7f] focus:border-transparent transition placeholder:text-slate-400 text-slate-800"
                                    placeholder="600 000 000" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Correu Electrònic</label>
                                <input
                                    type="email"
                                    class="w-full p-4 rounded-xl bg-[#f3f4f6] border border-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0f5f7f] focus:border-transparent transition placeholder:text-slate-400 text-slate-800"
                                    placeholder="exemple@mail.com" />
                            </div>

                            <!-- Summary box -->
                            <div class="bg-[#f3f4f6] rounded-xl p-4 text-sm text-slate-600 space-y-1 border border-[#e5e7eb]">
                                <p class="font-semibold text-slate-800 mb-2">Resum de la reserva</p>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Servei</span>
                                    <span class="font-medium capitalize">{{ selectedService }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Data</span>
                                    <span class="font-medium">{{ selectedDate ? `${selectedDate} ${monthNames[currentMonth]} ${currentYear}` : '—' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Hora</span>
                                    <span class="font-medium">{{ selectedTime }}</span>
                                </div>
                            </div>

                            <div class="bg-[#f5f1e6] border-l-4 border-[#8a6d1a] p-4 rounded-xl text-sm italic text-[#6b5010]">
                                Recordi portar la seva Targeta de Soci Soler per gaudir dels avantatges exclusius.
                            </div>

                            <button
                                class="w-full py-4 bg-[#0f5f7f] text-white rounded-xl font-bold hover:bg-[#0c4a63] active:scale-[0.99] transition-all shadow-md">
                                Confirmar Reserva
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
</template>