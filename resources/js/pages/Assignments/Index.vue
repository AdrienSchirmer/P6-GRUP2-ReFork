<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import WebAppLayout from '@/layouts/WebAppLayout.vue';

defineProps<{
    assignments?: {
        id: number;
        name: string;
        address: string;
        phone_number: number;
        description: string;
        status: string;
        created_at: string;
        updated_at: string;
    }[];
}>();

const formRef = ref<HTMLFormElement | null>(null);
const verifyFormRef = ref<HTMLFormElement | null>(null);
const page = usePage<{ flash?: { success?: string } }>();
function onSuccess() {
    formRef.value?.reset();
    verifyFormRef.value?.reset();
}
</script>

<template>
    <WebAppLayout>
        <section class="min-h-screen bg-blue-50 px-4 py-8 sm:px-6 lg:px-10">
            <div
                v-if="page.props.flash?.success"
                class="mx-auto mb-5 w-full max-w-3xl rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
            >
                {{ page.props.flash?.success }}
            </div>
            <div
                class="mx-auto mb-5 w-full max-w-3xl rounded-2xl bg-white p-4 shadow-lg sm:p-6"
            >
                <h1 class="mb-4 text-xl font-bold text-[#00617E] sm:text-2xl">
                    Consultar encàrrecs
                </h1>

                <Form
                    ref="formRef"
                    action="/assignments/code"
                    method="post"
                    class="w-full"
                    @success="onSuccess"
                >
                    <label for="search" class="sr-only"> Search </label>

                    <div class="relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4"
                        >
                            <svg
                                class="h-5 w-5 text-gray-500"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>

                        <input
                            id="search"
                            type="email"
                            name="email"
                            placeholder="Consulta per corréu electrònic"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 py-3 ps-11 pe-28 text-sm text-gray-900 transition outline-none placeholder:text-gray-500 focus:border-[#00617E] focus:bg-white focus:ring-2 focus:ring-[#00617E]/20"
                        />

                        <button
                            preserve-scroll
                            type="submit"
                            class="absolute end-1.5 top-1/2 -translate-y-1/2 rounded-xl bg-[#00617E] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#004f66] focus:ring-2 focus:ring-[#00617E]/30 focus:outline-none"
                        >
                            Enviar Codi
                        </button>
                    </div>
                </Form>
            </div>
            <div
                class="mx-auto w-full max-w-3xl rounded-2xl bg-white p-4 shadow-lg sm:p-6"
            >
                <h1 class="mb-4 text-xl font-bold text-[#00617E] sm:text-2xl">
                    Verifica el codi
                </h1>

                <Form
                    ref="verifyFormRef"
                    action="/assignments/verify-code"
                    method="post"
                    class="w-full"
                    @success="onSuccess"
                >
                    <label for="verify-code" class="sr-only"> Codi </label>

                    <div class="space-y-3">
                        <input
                            id="verify-code"
                            type="text"
                            name="code"
                            placeholder="Codi"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 transition outline-none placeholder:text-gray-500 focus:border-[#00617E] focus:bg-white focus:ring-2 focus:ring-[#00617E]/20"
                        />

                        <p
                            v-if="$page.props.errors?.code"
                            class="text-sm text-red-600"
                        >
                            {{ $page.props.errors.code }}
                        </p>

                        <button
                            preserve-scroll
                            type="submit"
                            class="w-full rounded-xl bg-[#00617E] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#004f66] focus:ring-2 focus:ring-[#00617E]/30 focus:outline-none"
                        >
                            Aceptar
                        </button>
                    </div>
                </Form>
            </div>
            <div
                v-if="assignments && assignments.length > 0"
                class="mx-auto mt-5 w-full max-w-3xl rounded-2xl bg-white p-4 shadow-lg sm:p-6"
            >
                <h2 class="mb-4 text-xl font-bold text-[#00617E] sm:text-2xl">
                    Els teus encàrrecs
                </h2>

                <div class="space-y-3">
                    <div
                        v-for="assignment in assignments"
                        :key="assignment.id"
                        class="rounded-xl border border-gray-200 bg-gray-50 p-4"
                    >
                        <p class="font-semibold text-gray-800">
                            {{ assignment.name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ assignment.address }}
                        </p>
                        <p class="mt-1 text-sm text-gray-700">
                            {{ assignment.description }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                v-else-if="assignments && assignments.length === 0"
                class="mx-auto mt-5 w-full max-w-3xl rounded-2xl bg-white p-4 text-center text-gray-500 shadow-lg sm:p-6"
            >
                No s'han trobat encàrrecs per aquest correu.
            </div>
        </section>
    </WebAppLayout>
</template>
