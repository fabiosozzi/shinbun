<template>
    <div class="feed_news_content">
        <h2>
            <slot name="title"></slot>
        </h2>
        <div class="description">
            <slot name="description"></slot>
        </div>
        <div class="link">
            <slot name="link"></slot>
        </div>
    </div>
</template>

<style scoped>
    .feed_news_content {
        @apply grid grid-cols-12 p-4 bg-white shadow-md rounded-xl;
    }
    .feed_news_content h2 {
        @apply block col-span-12 mb-2 font-bold;
    }
    .feed_news_content .description {
        @apply block col-span-12 mb-2;
    }
    .feed_news_content .link {
        @apply block col-span-12 text-sm font-bold;
    }
</style>
