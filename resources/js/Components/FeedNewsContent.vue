<script setup>
    defineProps({
        link: String,
    });

</script>
<template>
    <div class="grid grid-cols-12 p-4 text-sm bg-white shadow-md rounded-xl">
        <div class="block col-span-12 mb-2 text-sm font-bold">
            <slot name="title"></slot>
        </div>
        <div class="block col-span-12 mb-2 text-sm [&_*]:text-sm">
            <slot name="description"></slot>
        </div>
        <div class="block col-span-12 mt-2 text-sm font-bol">
            <a :href="link" target="_blank" class="inline-flex items-center px-4 py-2 text-xs text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-md bg-primary-500 hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50">
                <slot name="link"></slot>
            </a>
        </div>
    </div>
</template>
