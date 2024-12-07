<script setup>
    import { onMounted, ref } from 'vue';
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import axios from 'axios';
    import FeedListItemSkeleton from '@/Components/FeedListItemSkeleton.vue';
    import FeedListItem from '@/Components/FeedListItem.vue';
    import FeedNewsListSkeleton from '@/Components/FeedNewsListSkeleton.vue';
    import FeedNewsItem from '@/Components/FeedNewsItem.vue';
    import FeedNewsContent from '@/Components/FeedNewsContent.vue';
    import Spinner from '@/Components/Spinner.vue';
    import FeedSubscriptionCount from '@/Components/FeedSubscriptionCount.vue';

    const props = defineProps({
        title: String,
        db_feeds: Object,
        user_id: Number,
    })

    const api_feed_subscriptions = ref(undefined)
    const api_news = ref(undefined)
    const api_news_content = ref(undefined)
    const selected_feed_id = ref(undefined)
    const selected_feed_item_id = ref(undefined)

    Echo.channel(`feed-subscriptions.${props.user_id}`)
        .listen('FeedSubscription\\FeedSubscriptionUpdated', (e) => {
            api_feed_subscriptions.value.forEach((feed) => {
                if (feed.id == e.feedSubscription.id) {
                    feed.status = e.feedSubscription.status
                }
            })
        })

    function get_feeds() {
        selected_feed_id.value = undefined
        selected_feed_item_id.value = undefined

        axios.get(route('api.feeds.index'))
            .then(response => {
                api_feed_subscriptions.value = response.data.feeds
                get_news(api_feed_subscriptions.value[0].id)
            });
    }

    function get_news(feed_id) {
        selected_feed_id.value = feed_id
        selected_feed_item_id.value = undefined

        api_news.value = undefined
        api_news_content.value = undefined
        axios.get(route('api.news.index', { feed_subscription_id: feed_id }))
            .then(response => {
                api_news.value = response.data.news
            });
    }

    function get_news_content(feed_item_id) {
        selected_feed_item_id.value = feed_item_id

        api_news_content.value = undefined
        axios.get(route('api.news.show', { feed: selected_feed_id.value, feed_subscription_item_id: feed_item_id }))
            .then(response => {
                api_news_content.value = response.data.news
            });
    }

    onMounted(() => {
        get_feeds()
    });
</script>

<template>
    <Head :title="title" />
    <AppLayout>
        <div class="w-full mx-auto full_height grow lg:flex">
                <div class="flex-1 xl:flex">
                    <div class="w-2/5 p-2 bg-gray-200">
                        <template v-if="api_feed_subscriptions == undefined">
                            <FeedListItemSkeleton v-for="db_feed in db_feeds"></FeedListItemSkeleton>
                        </template>
                        <template v-else>
                            <FeedListItem v-for="feed in api_feed_subscriptions" :feedId="feed.id" @click="get_news(feed.id)" :selected="feed.id == selected_feed_id ? true : false">
                                <template #title>
                                    <div class="text-xs font-bold">{{ feed.title }}</div>
                                </template>
                                <template #status>
                                    <Spinner v-if="feed.status == 'pending'"></Spinner>
                                    <FeedSubscriptionCount v-else>
                                        {{ feed.items_count }}
                                    </FeedSubscriptionCount>
                                </template>
                            </FeedListItem>
                        </template>
                    </div>

                    <div class="w-3/5 p-2">
                        <template v-if="api_news == undefined">
                            <FeedNewsListSkeleton></FeedNewsListSkeleton>
                        </template>
                        <template v-else>
                            <FeedNewsItem class="news_item" v-for="news in api_news" @click="get_news_content(news.id)" :class="{ selected: news.id == selected_feed_item_id }">
                                <template #pubDate>
                                    {{ news.pub_date }}
                                </template>
                                <template #title>
                                    {{ news.title }}
                                </template>
                            </FeedNewsItem>
                        </template>
                    </div>
                </div>

                <div class="p-2 bg-gray-100 lg:w-2/5">
                    <FeedNewsContent v-if="api_news_content !== undefined" :link="api_news_content.link">
                        <template #title>
                            {{ api_news_content.title }}
                        </template>
                        <template #description>
                            <div v-html="api_news_content.description"></div>
                        </template>
                        <template #link >
                            Leggi di più
                        </template>
                    </FeedNewsContent>
                </div>
        </div>
    </AppLayout>
</template>

<style>

div.news_item.selected {
    @apply bg-primary-500;
}
</style>
