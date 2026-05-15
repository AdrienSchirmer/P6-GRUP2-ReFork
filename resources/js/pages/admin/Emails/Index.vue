<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Trash2 } from 'lucide-vue-next';
import { update } from '@/routes/emails';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Administració dels Correus', href: 'admin/emails' },
];

const props = defineProps<{
    emails?: {
        id: number;
        email: string;
        active: number;
    }[];
}>();

const selectedEmailIds = ref<number[]>(
    props.emails
        ?.filter((email) => email.active === 1)
        .map((email) => email.id) ?? [],
);

const form = useForm({
    active: 0,
});

const handleChange = (emailId: number) => {
    const isActive = selectedEmailIds.value.includes(emailId);
    form.active = isActive ? 1 : 0;
    form.patch(`/admin/emails/${emailId}`);
};
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <div class="mb-6 flex items-start justify-between">
                <div>
                    <h1 class="mb-2 text-2xl font-semibold">
                        Configuració Correus
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Configura a on s'enviarà el correu de part admin, quan
                        un usuari crea un encàrrec o un reserva.
                    </p>
                </div>
                <Link
                    href="/admin/emails/create"
                    class="rounded-md bg-blue-600 px-4 py-2 text-lg font-medium text-white hover:bg-blue-700"
                >
                    Crear
                </Link>
            </div>
            <div
                v-if="emails && emails.length > 0"
                class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm"
            >
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-slate-700">
                                Correu
                            </th>
                            <th class="px-6 py-3 font-semibold text-slate-700">
                                Estat
                            </th>
                            <th class="px-6 py-3 font-semibold text-slate-700">
                                Accions
                            </th>
                            <th class="px-6 py-3 font-semibold text-slate-700">
                                Selecciona
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr
                            v-for="email in emails"
                            :key="email.id"
                            class="hover:bg-slate-50"
                        >
                            <td class="px-6 py-4 text-slate-800">
                                {{ email.email }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ email.active === 1 ? 'Actiu' : 'Inactiu' }}
                            </td>
                            <td class="px-6 py-4">
                                <Link>
                                    <Trash2
                                        class="h-4 w-4 text-slate-500 hover:text-red-500"
                                    />
                                </Link>
                            </td>
                            <td class="px-6 py-4">
                                <input
                                    type="checkbox"
                                    :disabled="
                                        selectedEmailIds.length >= 3 &&
                                        !selectedEmailIds.includes(email.id)
                                    "
                                    :id="`email-${email.id}`"
                                    :value="email.id"
                                    v-model="selectedEmailIds"
                                    @change="handleChange(email.id)"
                                    class="h-4 w-4 text-blue-600"
                                />
                                <label
                                    :for="`email-${email.id}`"
                                    class="sr-only"
                                >
                                    Seleccionar {{ email.email }}
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
