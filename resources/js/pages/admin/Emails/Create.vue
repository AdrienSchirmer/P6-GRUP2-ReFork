<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { store } from '@/routes/emails';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Crear Correus', href: 'admin/emails/create' },
];
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="mb-6 text-2xl font-semibold">Crear Correus</h1>
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <Form
                    :action="store()"
                    method="post"
                    class="space-y-6"
                    #default="{ errors, validating }"
                >
                    <div>
                        <label class="mb-2 block text-lg text-gray-900 italic">
                            Correu electrònic
                        </label>
                        <input
                            type="email"
                            name="email"
                            class="w-full rounded-2xl border-none bg-gray-200 px-4 py-4 outline-none"
                            required
                        />
                        <p
                            v-if="errors.email"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ errors.email }}
                        </p>
                    </div>

                    <!-- <div class="flex items-center gap-3">
                        <input
                            id="active"
                            type="checkbox"
                            name="active"
                            value="1"
                            class="h-5 w-5 rounded border-gray-300 bg-gray-200 accent-gray-500"
                        />
                        <label for="active" class="text-base text-gray-800">
                            Actiu
                        </label>
                    </div> -->

                    <div>
                        <button
                            type="submit"
                            :disabled="validating"
                            class="rounded-2xl bg-yellow-300 px-4 py-3 text-lg font-medium sm:text-xl"
                        >
                            Crear correu
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </AppLayout>
</template>
