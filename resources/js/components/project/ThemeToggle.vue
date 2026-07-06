<script setup lang="ts">
import { Moon, Sun } from '@lucide/vue';
import { useAppearance } from '@/composables/useAppearance';

const { appearance, updateAppearance } = useAppearance();

function toggle() {
    updateAppearance(appearance.value === 'dark' ? 'light' : 'dark');
}
</script>

<template>
    <button
        @click="toggle"
        :title="appearance === 'dark' ? 'Gaišais režīms' : 'Tumšais režīms'"
        class="flex h-9 w-9 items-center justify-center rounded-md text-neutral-500 transition-colors hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-neutral-100"
    >
        <Sun v-if="appearance === 'dark'" class="h-5 w-5" />
        <Moon v-else class="h-5 w-5" />
    </button>
</template>
