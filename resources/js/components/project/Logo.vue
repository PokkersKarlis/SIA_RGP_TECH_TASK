<script setup lang="ts">
import { Film } from '@lucide/vue';
defineProps<{
    title: string;
}>();
</script>
<template>
    <div class="flex items-center space-x-2 group cursor-pointer">
        <div class="w-10 h-10 bg-gradient-to-tr from-violet-600 to-fuchsia-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20 group-hover:scale-105 transition-transform duration-300"
            style="box-shadow: 0 4px 6px rgba(128, 90, 213, 0.3), 0 1px 3px rgba(128, 90, 213, 0.2);">
            <Film class="w-5 h-5 text-slate-950" />
        </div>
        <span
            class="text-sm font-bold tracking-wider uppercase bg-gradient-to-r from-slate-900 via-slate-700 to-slate-500 bg-clip-text text-transparent dark:from-white dark:via-slate-200 dark:to-slate-400">
            {{ title }}
        </span>
    </div>
</template>
