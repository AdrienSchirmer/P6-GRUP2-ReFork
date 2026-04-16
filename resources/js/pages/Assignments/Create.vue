<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import { store } from '@/routes/assignments';
import { Form } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps<{ turnstileSiteKey: string | null }>();

onMounted(() => {
    if (!props.turnstileSiteKey || document.getElementById('cf-turnstile-api'))
        return;
    const s = document.createElement('script');
    s.id = 'cf-turnstile-api';
    s.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
    s.async = true;
    s.defer = true;
    document.head.appendChild(s);
});
</script>
<template>
    <WebAppLayout>
        <div class="min-h-screen bg-blue-50 px-50 py-8">
            <div class="pb-20">
                <h1 class="px-20 text-center text-4xl font-extrabold">
                    En nuestra farmacia preparamos tus encargos online.
                    Infórmate
                </h1>
                <h2 class="pt-10 text-2xl font-bold">
                    Realiza tu encargo online de productos de parafarmacia y
                    ahorra tiempo.
                </h2>
                <p>
                    Esta funcionalidad no está operativa para medicamentos. Tu
                    farmacia te avisará cuando tu pedido esté listo para
                    recogerlo.
                </p>
            </div>
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

                    <div class="flex items-center gap-3">
                        <input
                            required
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
                    <div v-if="props.turnstileSiteKey" class="pt-2">
                        <div
                            class="cf-turnstile"
                            :data-sitekey="props.turnstileSiteKey"
                            data-language="es"
                        ></div>
                        <p
                            v-if="errors['cf-turnstile-response']"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ errors['cf-turnstile-response'] }}
                        </p>
                    </div>

                    <div>
                        <button
                            preserve-scroll
                            class="rounded-2xl bg-yellow-300 p-3 text-2xl font-medium"
                            type="submit"
                            :disabled="validating"
                        >
                            Enviar
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </WebAppLayout>
</template>
