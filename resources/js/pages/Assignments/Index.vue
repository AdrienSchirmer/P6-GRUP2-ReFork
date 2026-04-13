<script setup lang="ts">
import WebAppLayout from '@/layouts/WebAppLayout.vue';
</script>
<template>
    <WebAppLayout>
        <div class="min-h-screen bg-blue-50 p-8">
            <div class="space-y-6">
                <div>
                    <label class="mb-2 block text-lg text-gray-900 italic"
                        >Nom</label
                    >
                    <input
                        type="text"
                        class="w-full rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                    />
                </div>

                <div class="flex gap-6">
                    <div class="flex-1">
                        <label class="mb-2 block text-lg text-gray-900 italic"
                            >Adreça</label
                        >
                        <input
                            type="text"
                            class="w-full rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                        />
                    </div>
                    <div class="flex-1">
                        <label class="mb-2 block text-lg text-gray-900 italic"
                            >Telefón</label
                        >
                        <input
                            type="text"
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
                        class="w-full resize-none rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                    />
                </div>

                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        class="h-5 w-5 cursor-pointer rounded border-gray-300 bg-gray-200 accent-gray-500"
                    />
                    <span class="text-sm text-gray-800">
                        He leído y acepto las
                        <a href="#" class="underline">condiciones de uso</a>
                        y la
                        <a href="#" class="underline">política de privacidad</a>
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
            </div>
        </div>
    </WebAppLayout>
</template>
