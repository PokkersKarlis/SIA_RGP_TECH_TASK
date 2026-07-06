<script setup lang="ts">
import Header from '@/components/project/Header.vue';
import FilmSearch from '@/components/project/FilmSearch.vue';
import MovieCard from '@/components/project/MovieCard.vue';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { KeyRound, TriangleAlert, Clapperboard } from '@lucide/vue';
import type { Movie } from '@/types';
import MovieModal from '@/components/project/MovieModal.vue';

const props = defineProps<{
    omdbToken: string | null;
    searchHistory: string[];
    searchResults: { Search?: Movie[]; Response: string; Error?: string } | null;
    lastQuery?: string;
}>();

const isTokenProvided = computed(() => !!props.omdbToken);

const selectedImdbId = ref<string | null>(null);

function handleTokenSave(token: string) {
    router.post('/api-token', { token }, { preserveScroll: true });
}

function handleTokenDelete() {
    router.delete('/api-token', { preserveScroll: true });
}

function openMovie(movie: Movie) {
    selectedImdbId.value = movie.imdbID;
}

function closeMovie() {
    selectedImdbId.value = null;
}

function handleSearch(query: string) {
    router.post('/search', { query }, {
        preserveScroll: true,
        preserveUrl: true,
    });
}

const hasSearched = computed(() => props.searchResults !== null && props.searchResults !== undefined);
const hasResults = computed(() => !!props.searchResults?.Search?.length);
const isApiKeyError = computed(() =>
    props.searchResults?.Error?.toLowerCase().includes('api key') ?? false
);
const isUnknownError = computed(() =>
    props.searchResults?.Error?.toLowerCase().includes('unknown_error') ?? false
);
const isNotFound = computed(() =>
    hasSearched.value && !hasResults.value && !isApiKeyError.value && props.searchResults?.Error?.toLowerCase().includes('not found')
);
</script>
<template>
    <!-- HEADER -->
    <Header :initial-token="props.omdbToken" @save="handleTokenSave" @delete="handleTokenDelete" />

    <!-- MAIN CONTAINER -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24 relative z-10">

        <!-- SEARCH SECTION -->
        <film-search :disabled="!isTokenProvided" :search-history="props.searchHistory" @search="handleSearch" />

        <Transition name="fade" mode="out-in">
            <!-- API KEY ERROR -->
            <section v-if="isApiKeyError" key="api-error"
                class="mt-12 text-center py-16 border border-rose-500/20 rounded-3xl bg-rose-950/10 backdrop-blur-sm max-w-xl mx-auto space-y-4">
                <div
                    class="w-16 h-16 bg-rose-500/10 rounded-2xl flex items-center justify-center mx-auto border border-rose-500/20 text-rose-400">
                    <KeyRound :size="28" />
                </div>
                <div class="space-y-1">
                    <p class="text-white font-medium text-sm">Nederīga API atslēga</p>
                    <p class="text-slate-500 text-xs max-w-xs mx-auto font-light">
                        Ievadi derīgu IMDb API tokenu augšējā joslā, lai varētu veikt meklēšanu.
                    </p>
                </div>
            </section>

            <!-- UNKNOWN ERROR -->
            <section v-else-if="isUnknownError" key="unknown-error"
                class="mt-12 text-center py-16 border border-rose-500/20 rounded-3xl bg-rose-950/10 backdrop-blur-sm max-w-xl mx-auto space-y-4">
                <div
                    class="w-16 h-16 bg-rose-500/10 rounded-2xl flex items-center justify-center mx-auto border border-rose-500/20 text-rose-400">
                    <TriangleAlert :size="20" />
                </div>
                <div class="space-y-1">
                    <p class="text-white font-medium text-sm">Nezināma kļūda</p>
                    <p class="text-slate-500 text-xs max-w-xs mx-auto font-light">
                        Radās nezināma kļūda, mēģini vēlreiz. Ja problēma saglabājas, sazinies ar atbalsta dienestu.
                    </p>
                </div>
            </section>

            <!-- NOTHING WAS FOUND -->
            <section v-else-if="isNotFound" key="not-found"
                class="mt-12 text-center py-16 border border-dashed border-white/5 rounded-3xl bg-slate-900/15 backdrop-blur-sm max-w-xl mx-auto space-y-4">
                <div
                    class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center mx-auto border border-white/5 text-slate-500">
                    <Clapperboard :size="28" />
                </div>
                <div class="space-y-1">
                    <p class="text-white font-medium text-sm">Nekas netika atrasts</p>
                    <p class="text-slate-500 text-xs max-w-xs mx-auto font-light">
                        Neizdevās atrast rezultātus vaicājumam "<span class="text-slate-300">{{ props.lastQuery
                        }}</span>". Mēģini citu meklēšanas terminu.
                    </p>
                </div>
            </section>

            <!-- INITIAL STATE -->
            <section v-else-if="!hasSearched" key="ready"
                class="mt-12 text-center py-16 border border-dashed border-white/5 rounded-3xl bg-slate-900/15 backdrop-blur-sm max-w-xl mx-auto space-y-4">
                <div
                    class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center mx-auto border border-white/5 text-slate-500">
                    <Clapperboard :size="28" />
                </div>
                <div class="space-y-1">
                    <p class="text-white font-medium text-sm">Gatavs meklēšanai</p>
                    <p class="text-slate-500 text-xs max-w-xs mx-auto font-light">
                        Ievadi filmas nosaukumu augšējā joslā, lai pieprasītu datus no IMDb servisa.
                    </p>
                </div>
            </section>

            <!-- RESULT GRID -->
            <section v-else-if="hasResults" key="results" class="space-y-6">
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <h2 class="text-lg font-semibold text-slate-200 flex items-center space-x-2">
                        <span class="w-1.5 h-4 bg-purple-500 rounded-full"></span>
                        <span>Meklēšanas rezultāti</span>
                    </h2>
                    <span class="text-xs text-slate-500 bg-slate-900 px-2.5 py-1 rounded-full border border-white/5">
                        Atrastas {{ props.searchResults?.Search?.length }} filmas
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    <MovieCard v-for="movie in props.searchResults?.Search" :key="movie.imdbID" :movie="movie"
                        @click="openMovie(movie)" />
                </div>
            </section>
        </Transition>
    </main>

    <!-- FOOTER -->
    <footer
        class="w-full border-t border-slate-200 dark:border-white/5 py-6 mt-auto bg-white/80 dark:bg-slate-950/80 backdrop-blur-md">
        <div
            class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-500 dark:text-slate-600 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>&copy; 2026 CineSearch. Visas tiesības aizsargātas.</p>
            <div class="flex space-x-4">
                <span class="hover:text-slate-700 dark:hover:text-slate-400 transition-colors cursor-pointer">Vue 3 +
                    Laravel API</span>
                <span>&middot;</span>
                <span class="hover:text-slate-700 dark:hover:text-slate-400 transition-colors cursor-pointer">IMDb
                    Wrapper</span>
                <span>&middot;</span>
                <span class="hover:text-slate-700 dark:hover:text-slate-400 transition-colors cursor-pointer">Autors
                    Kārlis Pokkers</span>
            </div>
        </div>
    </footer>
    <MovieModal :imdb-id="selectedImdbId" @close="closeMovie" />
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from {
    opacity: 0;
    transform: translateY(-8px);
}

.fade-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}
</style>