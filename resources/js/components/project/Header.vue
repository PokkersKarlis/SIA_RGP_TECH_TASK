<script setup lang="ts">
    import ApiTokenInput from './ApiTokenInput.vue';
    import Logo from './Logo.vue';

    const props = defineProps<{
        initialToken: string | null;
    }>();

    const emit = defineEmits<{
        save: [value: string];
        delete: [];
    }>();
</script>

<template>
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 flex justify-between items-center relative z-50">
        <Logo title="CineSearch" />
        <ApiTokenInput
            :initial-token="props.initialToken"
            @save="emit('save', $event)"
            @delete="emit('delete')"
        />
    </header>
</template>