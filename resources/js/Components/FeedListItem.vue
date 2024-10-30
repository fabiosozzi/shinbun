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
        <PrimaryButton class="w-full mb-2 text-left feed_item" :class="{ selected: selected }">
            <slot class="text-xs" name="title"></slot>
        </PrimaryButton>
    </div>
</template>
