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
            <div class="flex justify-between w-full">
                <div>
                    <slot name="title"></slot>
                </div>
                <div>
                    <slot name="status"></slot>
                </div>
            </div>
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
