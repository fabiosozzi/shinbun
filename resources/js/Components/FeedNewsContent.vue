<template>
    <div>
        <h2 class="block mb-4 font-bold">
            <slot class="text-xs" name="title"></slot>
        </h2>
        <slot class="text-xs" name="description"></slot>
        <slot class="text-xs" name="link"></slot>
    </div>
</template>
