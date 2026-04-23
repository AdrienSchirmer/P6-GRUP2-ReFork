<script setup lang="ts">
import { Link, router, Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { Eye, SquarePen, Trash2, Plus, CalendarPlus } from 'lucide-vue-next'
import { admindashboard as dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import AppLayout from '@/layouts/AppLayout.vue'

import {
    Pill,
    HeartPulse,
    FlaskConical,
    ShieldCheck,
    ScanFace,

} from 'lucide-vue-next'

const iconMap: Record<string, any> = {
    pill: Pill,
    heart: HeartPulse,
    flask: FlaskConical,
    shield: ShieldCheck,
    scan: ScanFace,

}

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Administració de serveis", href: dashboard().url },
]

interface Service {
    id: number
    name: string
    description: string
    duration_minutes: number
    icon: string | null
}


const props = defineProps<{
    services: Service[]
}>()

// SEARCH
const search = ref('')

const filteredServices = computed(() => {
    return props.services.filter(service =>
        service.name.toLowerCase().includes(search.value.toLowerCase())
    )
})

// DELETE MODAL
const selectedService = ref<Service | null>(null)
const showDeleteModal = ref(false)

function openDeleteModal(service: Service) {
    selectedService.value = service
    showDeleteModal.value = true
}

function closeDeleteModal() {
    showDeleteModal.value = false
}

/*function deleteService() {
    if (!selectedService.value) return

    router.delete(route('admin.services.destroy', selectedService.value.id), {
        onSuccess: () => {
            showDeleteModal.value = false
        }
    })
}*/
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Gestió de serveis" />

        <div class="p-6 space-y-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold">Gestió de Serveis</h1>
                    <p class="text-gray-500 text-sm">
                        Administra tots els serveis disponibles
                    </p>
                </div>


                <div class="flex items-center gap-3">

                    <input v-model="search" type="text" placeholder="Cercar servei..."
                        class="border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" />

                    <Link href="route('admin.services.create')"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-white"
                        style="background-color: #aadbf0">
                        <Plus class="w-4 h-4" />
                        Nou servei
                    </Link>

                </div>
            </div>




            <!-- TABLE -->
            <div class="bg-white rounded-xl shadow border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="p-3 text-left">Servei</th>
                            <th class="p-3 text-left">Descripció</th>
                            <th class="p-3 text-left">Durada</th>
                            <th class="p-3 text-right">Accions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="service in filteredServices" :key="service.id" class="border-t hover:bg-gray-50">
                            <!-- NAME + ICON -->
                            <td class="p-3">
                                <div class="flex items-center gap-2">

                                    <component v-if="service.icon && iconMap[service.icon]" :is="iconMap[service.icon]"
                                        class="w-5 h-5 text-blue-600" />

                                    <span class="font-medium">
                                        {{ service.name }}
                                    </span>
                                </div>
                            </td>

                            <td class="p-3 text-gray-600">
                                {{ service.description }}
                            </td>

                            <td class="p-3">
                                {{ service.duration_minutes }} min
                            </td>

                            <!-- ACTIONS -->
                            <td class="p-3">
                                <div class="flex justify-end gap-2 flex-wrap">

                                    <!-- VIEW -->
                                    <Link href="route('admin.services.show', service.id)"
                                        class="p-2 rounded hover:bg-green-100">
                                        <Eye class="w-4 h-4 text-green-600" />
                                    </Link>

                                    <!-- EDIT -->
                                    <Link href="route('admin.services.edit', service.id)"
                                        class="p-2 rounded hover:bg-orange-100">
                                        <SquarePen class="w-4 h-4 text-orange-600" />
                                    </Link>

                                    <!-- ADD SCHEDULE -->
                                    <Link href="route('admin.service-schedules.create', { service_id: service.id })"
                                        class="p-2 rounded hover:bg-blue-100">
                                        <CalendarPlus class="w-4 h-4 text-blue-600" />
                                    </Link>

                                    <!-- DELETE -->
                                    <button @click="openDeleteModal(service)" class="p-2 rounded hover:bg-red-100">
                                        <Trash2 class="w-4 h-4 text-red-600" />
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- DELETE MODAL -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md space-y-4">

                <h2 class="text-lg font-bold">Eliminar servei</h2>

                <p class="text-gray-600">
                    Estàs segur que vols eliminar aquest servei?
                </p>

                <p class="font-semibold">
                    {{ selectedService?.name }}
                </p>

                <div class="flex justify-end gap-3 pt-4">
                    <button @click="closeDeleteModal" class="px-4 py-2 border rounded">
                        Cancel·lar
                    </button>

                    <button click="deleteService" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Eliminar
                    </button>
                </div>

            </div>
        </div>

    </AppLayout>
</template>