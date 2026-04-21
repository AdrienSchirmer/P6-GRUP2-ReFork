<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { create as usersCreate, index as usersIndex, store as usersStore } from '@/routes/users';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Administració d'usuaris", href: usersIndex().url },
    { title: 'Crear usuari', href: usersCreate().url },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Crear usuari" />

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="rounded-xl border border-sidebar-border/70 bg-background p-6 dark:border-sidebar-border">
                <h1 class="text-2xl font-semibold tracking-tight">Crear usuari</h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Dona d'alta un nou usuari administrador.
                </p>
            </div>

            <div class="rounded-xl border border-sidebar-border/70 bg-background p-6 dark:border-sidebar-border">
                <Form
                    v-bind="usersStore.form()"
                    :reset-on-success="['password', 'password_confirmation']"
                    v-slot="{ errors, processing }"
                    class="grid gap-5"
                >
                    <div class="grid gap-2">
                        <Label for="name">Nom</Label>
                        <Input
                            id="name"
                            type="text"
                            name="name"
                            required
                            autofocus
                            placeholder="Nom complet"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Correu electrònic</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            required
                            placeholder="email@exemple.com"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="role">Rol</Label>
                        <select
                            id="role"
                            name="role"
                            required
                            class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                        >
                            <option value="admin" selected>Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                        <InputError :message="errors.role" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password">Contrasenya</Label>
                        <PasswordInput
                            id="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Contrasenya"
                        />
                        <InputError :message="errors.password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation">Confirmar contrasenya</Label>
                        <PasswordInput
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Repeteix la contrasenya"
                        />
                        <InputError :message="errors.password_confirmation" />
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-3">
                        <Button as-child type="button" variant="outline">
                            <Link :href="usersIndex().url">Cancel·lar</Link>
                        </Button>
                        <Button type="submit" :disabled="processing">
                            {{ processing ? 'Creant...' : 'Crear usuari' }}
                        </Button>
                    </div>
                </Form>
            </div>
        </div>
    </AppLayout>
</template>
