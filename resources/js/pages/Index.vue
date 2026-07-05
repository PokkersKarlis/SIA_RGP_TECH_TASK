<script setup lang="ts">
    import Header from '@/components/project/Header.vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps<{
        omdbToken: string | null;
    }>();

    function handleTokenSave(token: string) {
        router.post('/api-token', { token }, { preserveScroll: true });
    }

    function handleTokenDelete() {
        router.delete('/api-token', { preserveScroll: true });
    }

    
</script>
<template>
    <!-- HEADER -->
    <Header
        :initial-token="props.omdbToken" 
        @save="handleTokenSave"
        @delete="handleTokenDelete"
    />


    <!-- GALVENAIS KONTEINERS -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24 relative z-10">
        
        <!-- HERO / MEKLĒŠANAS SEKCIJA (Centrālais elements) -->
        <section class="max-w-3xl mx-auto text-center mb-16 space-y-6">
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white">
                Atrodi Savu Nākamo <br class="hidden sm:inline" />
                <span class="bg-gradient-to-r from-purple-400 via-violet-500 to-cyan-400 bg-clip-text text-transparent">Kino Šedevru</span>
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto font-light">
                Pārmeklē miljoniem filmu un seriālu datubāzes ar vienu klikšķi, izmantojot zibensātru IMDb integrāciju.
            </p>

            <!-- Epic Search Bar -->
            <div class="relative group max-w-2xl mx-auto pt-4">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-cyan-400 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000 group-focus-within:opacity-50"></div>
                <div class="relative flex items-center bg-slate-900/80 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden p-2 shadow-2xl">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 ml-4 text-lg"></i>
                    <input 
                        type="text" 
                        placeholder="Ievadi filmas nosaukumu (piem. Inception, Interstellar)..." 
                        class="w-full bg-transparent text-white placeholder-slate-500 pl-4 pr-4 py-3 text-base focus:outline-none"
                    />
                    <button class="bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-500 hover:to-violet-500 text-white font-medium px-6 py-3 rounded-xl text-sm transition-all duration-200 shadow-lg shadow-purple-900/40 shrink-0 flex items-center space-x-2 active:scale-95">
                        <span>Meklēt</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>
        </section>

        <!-- FILMU REZULTĀTU RŽĢIS -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-white/5 pb-4">
                <h2 class="text-lg font-semibold text-slate-200 flex items-center space-x-2">
                    <span class="w-1.5 h-4 bg-purple-500 rounded-full"></span>
                    <span>Meklēšanas rezultāti</span>
                </h2>
                <span class="text-xs text-slate-500 bg-slate-900 px-2.5 py-1 rounded-full border border-white/5">Atrastas 5 filmas</span>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                
                <!-- Filmas Kartīte 1 -->
                <div class="group bg-slate-900/40 border border-white/5 rounded-2xl overflow-hidden shadow-xl hover:border-purple-500/30 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/10 cursor-pointer">
                    <div class="relative aspect-[2/3] overflow-hidden bg-slate-950">
                        <!-- IMDb Rating Badge -->
                        <div class="absolute top-3 right-3 z-20 bg-slate-950/80 backdrop-blur-md border border-amber-500/30 text-amber-400 text-xs font-bold px-2 py-1 rounded-lg flex items-center space-x-1">
                            <i class="fa-solid fa-star text-[10px]"></i>
                            <span>8.8</span>
                        </div>
                        <!-- Poster Image (Placeholder representation) -->
                        <div class="w-full h-full bg-gradient-to-br from-slate-800 to-slate-900 flex flex-col items-center justify-center p-6 text-center group-hover:scale-105 transition-transform duration-500 relative">
                            <i class="fa-solid fa-images text-4xl text-slate-700 mb-3 group-hover:text-purple-400 transition-colors duration-300"></i>
                            <span class="text-xs text-slate-500 font-medium">Inception (2010)</span>
                            <!-- Absolūtais slānis elegantam hover efektam -->
                            <div class="absolute inset-0 card-gradient opacity-80 z-10"></div>
                        </div>
                        <!-- Hover info slānis -->
                        <div class="absolute inset-0 z-20 flex flex-col justify-end p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 card-gradient">
                            <p class="text-xs text-slate-300 line-clamp-3 font-light mb-1">
                                A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea.
                            </p>
                        </div>
                    </div>
                    <!-- Kartītes Apakša -->
                    <div class="p-4 space-y-1 bg-slate-900/20">
                        <h3 class="font-bold text-sm text-white truncate group-hover:text-purple-400 transition-colors duration-200">Inception</h3>
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span>2010</span>
                            <span class="text-[10px] tracking-wide uppercase px-1.5 py-0.5 bg-slate-800 rounded text-slate-300">Sci-Fi</span>
                        </div>
                    </div>
                </div>

                <!-- Filmas Kartīte 2 (Kā izskatītos ar reālu bildi) -->
                <div class="group bg-slate-900/40 border border-white/5 rounded-2xl overflow-hidden shadow-xl hover:border-purple-500/30 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/10 cursor-pointer">
                    <div class="relative aspect-[2/3] overflow-hidden bg-slate-950">
                        <div class="absolute top-3 right-3 z-20 bg-slate-950/80 backdrop-blur-md border border-amber-500/30 text-amber-400 text-xs font-bold px-2 py-1 rounded-lg flex items-center space-x-1">
                            <i class="fa-solid fa-star text-[10px]"></i>
                            <span>8.6</span>
                        </div>
                        <div class="w-full h-full bg-gradient-to-br from-purple-950/20 to-slate-900 flex flex-col items-center justify-center p-6 text-center group-hover:scale-105 transition-transform duration-500 relative">
                            <i class="fa-solid fa-space-shuttle text-4xl text-slate-700 mb-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            <span class="text-xs text-slate-500 font-medium">Interstellar (2014)</span>
                            <div class="absolute inset-0 card-gradient opacity-80 z-10"></div>
                        </div>
                        <div class="absolute inset-0 z-20 flex flex-col justify-end p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 card-gradient">
                            <p class="text-xs text-slate-300 line-clamp-3 font-light mb-1">
                                A team of explorers travel through a wormhole in space in an attempt to ensure humanity's survival.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 space-y-1 bg-slate-900/20">
                        <h3 class="font-bold text-sm text-white truncate group-hover:text-purple-400 transition-colors duration-200">Interstellar</h3>
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span>2014</span>
                            <span class="text-[10px] tracking-wide uppercase px-1.5 py-0.5 bg-slate-800 rounded text-slate-300">Adventure</span>
                        </div>
                    </div>
                </div>

                <!-- SKELETON LOADER PLACEHOLDER (Paraugs ielādes stāvoklim) -->
                <div class="bg-slate-900/20 border border-white/5 rounded-2xl overflow-hidden p-0 animate-pulse">
                    <div class="aspect-[2/3] bg-slate-900/60 w-full relative">
                        <div class="absolute top-3 right-3 bg-slate-800 h-6 w-12 rounded-lg"></div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="h-4 bg-slate-900 rounded w-3/4"></div>
                        <div class="flex justify-between">
                            <div class="h-3 bg-slate-900 rounded w-1/4"></div>
                            <div class="h-3 bg-slate-900 rounded w-1/4"></div>
                        </div>
                    </div>
                </div>

                <!-- SKELETON LOADER PLACEHOLDER 2 -->
                <div class="bg-slate-900/20 border border-white/5 rounded-2xl overflow-hidden p-0 animate-pulse hidden sm:block">
                    <div class="aspect-[2/3] bg-slate-900/60 w-full relative">
                        <div class="absolute top-3 right-3 bg-slate-800 h-6 w-12 rounded-lg"></div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="h-4 bg-slate-900 rounded w-1/2"></div>
                        <div class="flex justify-between">
                            <div class="h-3 bg-slate-900 rounded w-1/5"></div>
                            <div class="h-3 bg-slate-900 rounded w-1/4"></div>
                        </div>
                    </div>
                </div>

                <!-- SKELETON LOADER PLACEHOLDER 3 -->
                <div class="bg-slate-900/20 border border-white/5 rounded-2xl overflow-hidden p-0 animate-pulse hidden md:block">
                    <div class="aspect-[2/3] bg-slate-900/60 w-full relative">
                        <div class="absolute top-3 right-3 bg-slate-800 h-6 w-12 rounded-lg"></div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="h-4 bg-slate-900 rounded w-2/3"></div>
                        <div class="flex justify-between">
                            <div class="h-3 bg-slate-900 rounded w-1/3"></div>
                            <div class="h-3 bg-slate-900 rounded w-1/5"></div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- EMPTY STATE ALTERNATĪVA (Ja nekas nav ierakstīts) -->
        <!-- Noņem klasi 'hidden', lai redzētu vizuālo izskatu, kad rezultātu nav -->
        <section class="hidden mt-12 text-center py-16 border border-dashed border-white/5 rounded-3xl bg-slate-900/15 backdrop-blur-sm max-w-xl mx-auto space-y-4">
            <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center mx-auto border border-white/5 text-slate-500">
                <i class="fa-solid fa-clapperboard text-2xl"></i>
            </div>
            <div class="space-y-1">
                <p class="text-white font-medium text-sm">Gatavs meklēšanai</p>
                <p class="text-slate-500 text-xs max-w-xs mx-auto font-light">
                    Ievadi filmas nosaukumu augšējā joslā, lai pieprasītu datus no IMDb servisa.
                </p>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="w-full border-t border-white/5 py-6 mt-auto bg-slate-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-600 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>&copy; 2026 CineSearch. Visi šedevri aizsargāti.</p>
            <div class="flex space-x-4">
                <span class="hover:text-slate-400 transition-colors cursor-pointer">Vue 3 + Laravel API</span>
                <span>&middot;</span>
                <span class="hover:text-slate-400 transition-colors cursor-pointer">IMDb Wrapper</span>
            </div>
        </div>
    </footer>
</template>