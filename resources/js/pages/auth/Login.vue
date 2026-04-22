<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Accedeix al teu compte',
        description: 'Inicia sessió per gestionar el panell de Farmacia Soler',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <Head title="Iniciar sessió" />

    <div
        v-if="status"
        class="mb-5 rounded-xl border border-green-200 bg-green-50/90 px-4 py-3 text-center text-sm font-medium text-green-700"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-5"
    >
        <div class="grid gap-5">
            <div class="space-y-1">
                <h2 class="text-lg font-semibold text-[#0f5f7f] dark:text-foreground">
                    Benvingut de nou
                </h2>
                <p class="text-sm text-muted-foreground">
                    Introdueix les teves credencials per continuar.
                </p>
            </div>

            <div class="grid gap-2">
                <Label for="email">Correu electrònic</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="h-11 rounded-xl border-[#d5e3ec] focus-visible:border-[#0f5f7f] focus-visible:ring-[#0f5f7f]/25"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label for="password">Contrasenya</Label>
                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-sm text-[#0f5f7f] decoration-[#99bdd0] hover:decoration-[#0f5f7f]"
                        :tabindex="5"
                    >
                        Has oblidat la contrasenya?
                    </TextLink>
                </div>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Contrasenya"
                    class="h-11 rounded-xl border-[#d5e3ec] focus-visible:border-[#0f5f7f] focus-visible:ring-[#0f5f7f]/25"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                    <Checkbox id="remember" name="remember" :tabindex="3" />
                    <span>Recorda’m</span>
                </Label>
            </div>

            <Button
                type="submit"
                class="mt-2 h-11 w-full rounded-xl bg-[#0f5f7f] text-white shadow-sm transition hover:bg-[#0c4a63]"
                :tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" />
                Iniciar sessió
            </Button>
        </div>
    </Form>
</template>
