<script setup lang="ts">
import { ref, computed } from 'vue';
import { defineEmits } from 'vue';
import { Trash2, Plus, KeyRound } from '@lucide/vue';

const props = defineProps<{
    initialToken: string | null;
}>();

const token = ref(props.initialToken ?? '');

const isTokenProvided = computed(() => !!props.initialToken);

const emit = defineEmits<{
    save: [value: string];
    delete: [];
}>();



function handleSaveToken(tokenValue: string) {
    emit('save', tokenValue);
}

function handleDeleteToken() {
    token.value = '';
    emit('delete');
}
</script>
<template>
    <div
        class="flex items-center space-x-2 bg-slate-900/40 backdrop-blur-md border border-slate-400 p-1.5 rounded-xl transition-all duration-300 border-slate-400 hover:border-white/10">
        <div class="relative flex items-center">
            <KeyRound class="w-3 h-3 absolute left-2.5 text-slate-500" />
            <input v-model="token" :disabled="isTokenProvided" type="password" placeholder="IMDb API Token..."
                class="w-36 sm:w-48 bg-slate-950/60 border border-slate-400 focus:border-purple-500/50 rounded-lg pl-8 pr-3 py-1 text-xs text-slate-100 placeholder-slate-300 focus:outline-none focus:ring-1 focus:ring-purple-500/30 transition-all duration-300" />
        </div>
        <button
            class="px-2.5 py-1 rounded-lg text-xs font-medium tracking-wide transition-all duration-200 flex items-center space-x-1"
            :class="isTokenProvided || !token
                ? 'bg-slate-800/30 text-slate-600 cursor-not-allowed'
                : 'bg-purple-600/10 hover:bg-purple-600 text-purple-400 hover:text-white active:scale-95'"
            @click="handleSaveToken(token)" :disabled="isTokenProvided || !token">
            <Plus class="w-3 h-3" />
            <span class="hidden sm:inline">Saglabāt</span>
        </button>
        <button class="px-2.5 py-1 rounded-lg text-xs font-medium transition-all duration-200" :class="!isTokenProvided
            ? 'bg-slate-800/30 text-slate-600 cursor-not-allowed'
            : 'bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 hover:text-rose-300 active:scale-95'"
            title="Dzēst Tokenu" :disabled="!isTokenProvided" @click="handleDeleteToken">
            <Trash2 class="w-3 h-3" />
        </button>
    </div>
</template>
"