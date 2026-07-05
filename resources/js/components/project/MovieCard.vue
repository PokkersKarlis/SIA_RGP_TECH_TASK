<script setup lang="ts">
import { Images } from '@lucide/vue';
import type { Movie } from '@/types';

defineProps<{
    movie: Movie;
}>();
</script>

<template>
    <div class="group bg-slate-900/40 border border-white/5 rounded-2xl overflow-hidden shadow-xl hover:border-purple-500/30 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/10 cursor-pointer">
        <div class="relative aspect-[2/3] overflow-hidden bg-slate-950">
            <img
                v-if="movie.Poster && movie.Poster !== 'N/A'"
                :src="movie.Poster"
                :alt="movie.Title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
            <div
                v-else
                class="w-full h-full bg-gradient-to-br from-slate-800 to-slate-900 flex flex-col items-center justify-center p-6 text-center"
            >
                <Images :size="40" class="text-slate-700 mb-3" />
                <span class="text-xs text-slate-500 font-medium">{{ movie.Title }}</span>
            </div>
        </div>
        <div class="p-4 space-y-1 bg-slate-900/20">
            <h3 class="font-bold text-sm text-white truncate group-hover:text-purple-400 transition-colors duration-200">
                {{ movie.Title }}
            </h3>
            <div class="flex items-center justify-between text-xs text-slate-400">
                <span>{{ movie.Year }}</span>
                <span class="text-[10px] tracking-wide uppercase px-1.5 py-0.5 bg-slate-800 rounded text-slate-300">
                    {{ movie.Type }}
                </span>
            </div>
        </div>
    </div>
</template>