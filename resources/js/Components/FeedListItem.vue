<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue'

    defineProps({
        selected: {
            type: Boolean
        },
    });
</script>

<template>
    <div>
        <PrimaryButton class="feed-list-item" :class="{ selected: selected }">
            <slot name="title"></slot>
        </PrimaryButton>
    </div>
</template>

<style scoped>
    .feed-list-item {
        @apply w-full mb-2 text-sm text-left;
    }
    .feed-list-item.selected {
        @apply bg-primary-600;
    }
</style>
