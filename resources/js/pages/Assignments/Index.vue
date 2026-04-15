<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import { store } from '@/routes/assignments';
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
</script>
<template>
    <WebAppLayout>
        <div class="min-h-screen bg-blue-50 p-8">
            <div class="space-y-6">
                <Form
                    :action="store()"
                    method="POST"
                    class="space-y-4"
                    #default="{ errors, invalid, validate, validating }"
                >
                    <div>
                        <label class="mb-2 block text-lg text-gray-900 italic"
                            >Nom</label
                        >
                        <input
                            type="text"
                            name="name"
                            class="w-full rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                        />
                    </div>

                    <div class="flex gap-6">
                        <div class="flex-1">
                            <label
                                class="mb-2 block text-lg text-gray-900 italic"
                                >Adreça</label
                            >
                            <input
                                type="email"
                                name="address"
                                class="w-full rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                            />
                        </div>
                        <div class="flex-1">
                            <label
                                class="mb-2 block text-lg text-gray-900 italic"
                                >Telefón</label
                            >
                            <input
                                type="tel"
                                name="phone_number"
                                class="w-full rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-lg text-gray-900 italic"
                            >Descripció</label
                        >
                        <textarea
                            rows="8"
                            name="description"
                            class="w-full resize-none rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                        />
                    </div>
                    x

                    <div class="flex items-center gap-3">
                        <input
                            type="checkbox"
                            class="h-5 w-5 cursor-pointer rounded border-gray-300 bg-gray-200 accent-gray-500"
                        />
                        <span class="text-sm text-gray-800">
                            He leído y acepto las
                            <a href="#" class="underline">condiciones de uso</a>
                            y la
                            <a href="#" class="underline"
                                >política de privacidad</a
                            >
                        </span>
                    </div>
                    <div>
                        <button
                            class="rounded-2xl bg-yellow-300 p-3 text-2xl font-medium"
                            type="submit"
                        >
                            Enviar
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </WebAppLayout>
</template>
