<script setup lang="ts">
import { ref, watch } from 'vue';
import { X, Star, Loader2 } from '@lucide/vue';

const props = defineProps<{
    imdbId: string | null;
}>();

const emit = defineEmits<{
    close: [];
}>();

interface MovieDetails {
    Title: string;
    Year: string;
    Plot: string;
    Poster: string;
    imdbRating: string;
    Genre: string;
    Director: string;
    Actors: string;
    Runtime: string;
    Response: string;
    Error?: string;
}

const details = ref<MovieDetails | null>(null);
const isLoading = ref(false);

watch(() => props.imdbId, async (id) => {
    if (!id) {
        details.value = null;
        return;
    }

    isLoading.value = true;
    details.value = null;

    try {
        const response = await fetch(`/movies/${id}`);
        details.value = await response.json();
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <Teleport to="body">
        <div
            v-if="imdbId"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
            @click.self="emit('close')"
        >
            <div class="bg-slate-900 border border-white/10 rounded-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto relative shadow-2xl">
                <button
                    type="button"
                    class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-slate-950/80 flex items-center justify-center text-slate-400 hover:text-white transition-colors"
                    @click="emit('close')"
                >
                    <X :size="18" />
                </button>

                <div v-if="isLoading" class="flex flex-col items-center justify-center py-24 space-y-3">
                    <Loader2 :size="32" class="text-purple-400 animate-spin" />
                    <p class="text-slate-500 text-sm">Ielādē informāciju...</p>
                </div>

                <div v-else-if="details && details.Response === 'True'" class="flex flex-col sm:flex-row">
                    <img
                        v-if="details.Poster && details.Poster !== 'N/A'"
                        :src="details.Poster"
                        :alt="details.Title"
                        class="w-full sm:w-64 h-80 sm:h-auto object-cover"
                    />
                    <div class="p-6 space-y-4 flex-1">
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ details.Title }}</h2>
                            <p class="text-slate-400 text-sm">{{ details.Year }} &middot; {{ details.Runtime }} &middot; {{ details.Genre }}</p>
                        </div>

                        <div class="flex items-center space-x-1 text-amber-400">
                            <Star :size="16" />
                            <span class="font-bold">{{ details.imdbRating }}</span>
                            <span class="text-slate-500 text-xs">/ 10</span>
                        </div>

                        <p class="text-slate-300 text-sm leading-relaxed">{{ details.Plot }}</p>

                        <div class="space-y-1 text-xs text-slate-500">
                            <p><span class="text-slate-400 font-medium">Režisors:</span> {{ details.Director }}</p>
                            <p><span class="text-slate-400 font-medium">Aktieri:</span> {{ details.Actors }}</p>
                        </div>
                    </div>
                </div>

                <div v-else class="flex flex-col items-center justify-center py-24 space-y-2 px-6 text-center">
                    <p class="text-white font-medium text-sm">Neizdevās ielādēt informāciju</p>
                    <p class="text-slate-500 text-xs">{{ details?.Error ?? 'Mēģini vēlreiz.' }}</p>
                </div>
            </div>
        </div>
    </Teleport>
</template>