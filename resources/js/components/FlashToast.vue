<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watch } from 'vue';

const page = usePage<{
    flash?: {
        success?: string;
        error?: string;
    };
}>();

const visible = ref(false);
const message = ref('');
const type = ref<'success' | 'error'>('success');
let timer: ReturnType<typeof setTimeout> | null = null;

function show(msg: string, t: 'success' | 'error') {
    if (timer) {
        clearTimeout(timer);
    }

    message.value = msg;
    type.value = t;
    visible.value = true;
    timer = setTimeout(() => {
        visible.value = false;
    }, 4000);
}

watch(
    () => [page.props.flash?.success, page.props.flash?.error] as const,
    ([success, error]) => {
        if (success) {
            show(success, 'success');
        } else if (error) {
            show(error, 'error');
        }
    },
);

onMounted(() => {
    const flash = page.props.flash;
    if (flash?.success) {
        show(flash.success, 'success');
    } else if (flash?.error) {
        show(flash.error, 'error');
    }
});

onUnmounted(() => {
    if (timer) {
        clearTimeout(timer);
    }
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-4 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-4 opacity-0"
    >
        <div
            v-if="visible"
            class="fixed right-4 bottom-4 z-50 flex items-center gap-3 rounded-xl border px-8 py-6 shadow-lg"
            :class="
                type === 'success'
                    ? 'border-green-200 bg-green-50 text-green-800'
                    : 'border-red-200 bg-red-50 text-red-800'
            "
        >
            <svg
                v-if="type === 'success'"
                class="h-5 w-5 shrink-0 text-green-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />
            </svg>
            <svg
                v-else
                class="h-5 w-5 shrink-0 text-red-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
            <span class="text-sm font-medium">{{ message }}</span>
            <button
                class="ml-2 cursor-pointer rounded p-0.5 opacity-60 transition hover:opacity-100"
                @click="visible = false"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
    </Transition>
</template>
