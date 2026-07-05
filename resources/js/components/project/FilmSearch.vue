<script setup lang="ts">
import { ref } from 'vue';

const props = withDefaults(defineProps<{
    disabled: boolean;
    searchHistory: string[];
}>(), {
    searchHistory: () => [],
});

const emit = defineEmits<{
    search: [query: string];
}>();

const query = ref('');
const showHistory = ref(false);

function triggerSearch(searchQuery?: string) {
    const finalQuery = (searchQuery ?? query.value).trim();
    if (!finalQuery) return;

    query.value = finalQuery;
    showHistory.value = false;
    emit('search', finalQuery);
}

function selectHistoryItem(item: string) {
    triggerSearch(item);
}

function handleFocus() {
    if (props.searchHistory.length > 0) {
        showHistory.value = true;
    }
}

function handleBlur() {
    setTimeout(() => {
        showHistory.value = false;
    }, 150);
}
</script>

<template>
    <section class="max-w-3xl mx-auto text-center mb-16 space-y-6">
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white">
            Atrodi Savu Nākamo <br class="hidden sm:inline" />
            <span class="bg-gradient-to-r from-purple-400 via-violet-500 to-cyan-400 bg-clip-text text-transparent">Kino Šedevru</span>
        </h1>
        <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto font-light">
            Pārmeklē miljoniem filmu un seriālu datubāzes ar vienu klikšķi, izmantojot IMDb integrāciju.
        </p>

        <div class="relative group max-w-2xl mx-auto pt-4">
            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-cyan-400 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000 group-focus-within:opacity-50"></div>
            <div class="relative flex items-center bg-slate-900/80 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden p-2 shadow-2xl">
                <i class="fa-solid fa-magnifying-glass text-slate-400 ml-4 text-lg"></i>
                <input
                    v-model="query"
                    type="text"
                    :disabled="props.disabled"
                    placeholder="Ievadi filmas nosaukumu (piem. Inception, Interstellar)..."
                    class="w-full bg-transparent text-white placeholder-slate-500 pl-4 pr-4 py-3 text-base focus:outline-none"
                    @keyup.enter="triggerSearch()"
                    @focus="handleFocus"
                    @blur="handleBlur"
                />
                <button
                    class="bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-500 hover:to-violet-500 text-white font-medium px-6 py-3 rounded-xl text-sm transition-all duration-200 shadow-lg shadow-purple-900/40 shrink-0 flex items-center space-x-2 active:scale-95"
                    :class="props.disabled ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="props.disabled"
                    type="button"
                    @click="triggerSearch()"
                >
                    <span>Meklēt</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>

            <div
                v-if="showHistory && searchHistory.length > 0"
                class="absolute top-full left-0 right-0 mt-2 bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-xl overflow-hidden shadow-2xl z-30 text-left"
            >
                <div class="px-4 py-2 text-xs text-slate-500 border-b border-white/5">Nesenā vēsture</div>
                <button
                    v-for="item in searchHistory"
                    :key="item"
                    type="button"
                    class="w-full text-left px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-800/60 transition-colors flex items-center space-x-2"
                    @click="selectHistoryItem(item)"
                >
                    <i class="fa-solid fa-clock-rotate-left text-xs text-slate-500"></i>
                    <span>{{ item }}</span>
                </button>
            </div>
        </div>
    </section>
</template>