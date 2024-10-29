<script setup>
    import { onMounted, ref } from 'vue';
    import { Head, Link } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import axios from 'axios';
    import FeedListItemSkeleton from '@/Components/FeedListItemSkeleton.vue';
    import FeedListItem from '@/Components/FeedListItem.vue';
    import FeedNewsListSkeleton from '@/Components/FeedNewsListSkeleton.vue';
    import FeedNewsItem from '@/Components/FeedNewsItem.vue';

    const props = defineProps({
        title: String,
        db_feeds: Object,
        selected_feed: Number,
        selected_news: Number,
    })


    const api_feeds = ref(undefined)
    const api_news = ref(undefined)

    function get_feeds() {
        axios.get(route('api.feeds.index'))
            .then(response => {
                api_feeds.value = response.data.feeds
                get_news(api_feeds.value[0].id)
            });
    }

    function get_news(feed_id) {
        api_news.value = undefined
        axios.get(route('api.news.index', { feed: feed_id }))
            .then(response => {
                api_news.value = response.data.news
            });
    }

    onMounted(() => {
        get_feeds()
    });
</script>

<template>
    <Head :title="title" />
    <AppLayout>
        <div class="w-full mx-auto grow lg:flex xl:px-2">
                <!-- Left sidebar & main wrapper -->
                <div class="flex-1 xl:flex">
                    <div class="px-4 py-6 border-b border-gray-200 sm:px-6 lg:pl-8 xl:w-64 xl:shrink-0 xl:border-b-0 xl:border-r xl:pl-6">
                        <template v-if="api_feeds == undefined">
                            <FeedListItemSkeleton v-for="db_feed in db_feeds"></FeedListItemSkeleton>
                        </template>
                        <template v-else>
                            <FeedListItem v-for="feed in api_feeds" :feedId="feed.id" @click="get_news(feed.id)">
                                <template #title>
                                    <h2 class="font-bold">{{ feed.title }}</h2>
                                </template>
                            </FeedListItem>
                        </template>
                    </div>

                    <div class="px-4 py-6 sm:px-6 lg:pl-8 xl:flex-1 xl:pl-6">
                        <template v-if="api_news == undefined">
                            <FeedNewsListSkeleton></FeedNewsListSkeleton>
                        </template>
                        <template v-else>
                            <FeedNewsItem v-for="news in api_news">
                                <template #title>
                                    {{ news.title }}
                                </template>
                            </FeedNewsItem>
                        </template>
                    </div>
                </div>

                <div class="px-4 py-6 border-t border-gray-200 shrink-0 sm:px-6 lg:w-96 lg:border-l lg:border-t-0 lg:pr-8 xl:pr-6">
                    Right column area
                </div>
        </div>
    </AppLayout>
</template>
