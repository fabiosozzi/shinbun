<script setup>
    import { Link } from '@inertiajs/vue3'

    import PrimaryButton from '@/Components/PrimaryButton.vue'
</script>

<template>
    <div>
        <PrimaryButton class="mb-2" @click="Inertia">
            <slot class="text-xs" name="title"></slot>
        </PrimaryButton>
    </div>
</template>
