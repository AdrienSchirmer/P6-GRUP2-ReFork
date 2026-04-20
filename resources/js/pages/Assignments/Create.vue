<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
import { store } from '@/routes/assignments';
import { Form } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';

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

const formRef = ref<HTMLFormElement | null>(null);

function onSuccess() {
    formRef.value?.reset();
}
</script>
<template>
    <WebAppLayout>
        <div class="min-h-screen bg-blue-50 px-50 py-8">
            <div class="pb-10">
                <h1 class="text-4xl font-extrabold">Encàrrecs</h1>
            </div>
            <div class="flex items-center gap-3 pb-5">
                <h2
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#00617E] text-3xl leading-none font-extrabold text-white italic"
                >
                    <span class="-translate-x-px">1</span>
                </h2>
                <p class="text-2xl italic">Demana el que necessitis.</p>
            </div>
            <div class="grid grid-cols-3 gap-5">
                <div
                    class="col-span-2 space-y-6 rounded-2xl bg-[#ffffff] p-5 shadow-lg"
                >
                    <Form
                        ref="formRef"
                        :action="store()"
                        method="POST"
                        class="space-y-4"
                        @success="onSuccess"
                        #default="{ errors, invalid, validate, validating }"
                    >
                        <div>
                            <label
                                class="mb-2 block text-lg text-gray-900 italic"
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
                            <label
                                class="mb-2 block text-lg text-gray-900 italic"
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
                                <a href="#" class="underline"
                                    >condiciones de uso</a
                                >
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
                <div class="space-y-6 rounded-2xl bg-[#ffffff] p-5 shadow-lg">
                    <div class="flex items-center gap-3 pb-5">
                        <h2
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#00617E] text-3xl leading-none font-extrabold text-white italic"
                        >
                            <span class="-translate-x-px">2</span>
                        </h2>
                        <p class="text-2xl italic">
                            Prepararem el teu encarrec lo abans possible i
                            t’enviarem un missatge quan ja estigui llest.
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pb-5">
                        <h2
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#00617E] text-3xl leading-none font-extrabold text-white italic"
                        >
                            <span class="-translate-x-px">3</span>
                        </h2>
                        <p class="text-2xl italic">
                            Vina a buscar el teu encarrec i paga a la nostre
                            farmacia!
                        </p>
                    </div>
                    <div>
                        <img
                            src="/storage/vagaro-ckWrZO5sWOQ-unsplash.jpg"
                            alt="Image"
                        />
                    </div>
                </div>
            </div>
        </div>
    </WebAppLayout>
</template>
