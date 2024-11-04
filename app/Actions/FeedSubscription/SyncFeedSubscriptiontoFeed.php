<?php

namespace App\Actions\FeedSubscription;

use App\Events\FeedSubscription\FeedSubscriptionUpdated;
use App\Jobs\FeedSubscription\SyncFeedSubscriptionItemsToFeedItemsJob;
use App\Models\Feed;
use App\Models\FeedSubscription;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncFeedSubscriptiontoFeed
{
    use AsAction;

    public function handle(Feed $feed, FeedSubscription $feedSubscription): FeedSubscription
    {
        $array_batch_calls = [];

        $feed->feed_items->chunk(config('feeds.chunk_size_items_import'))->each(function ($items) use ($feedSubscription, &$array_batch_calls) {
            $array_items = $items->map(function ($item) use ($feedSubscription) {
                return [
                    'feed_subscription_id' => $feedSubscription->id,
                    'title' => $item->title,
                    'guid' => $item->guid,
                    'link' => $item->link,
                    'description' => $item->description,
                    'pub_date' => $item->pub_date,
                ];
            });
            $array_batch_calls[] = new SyncFeedSubscriptionItemsToFeedItemsJob($feedSubscription, $array_items->toArray());
        });

        Bus::batch($array_batch_calls)
            ->before(function (Batch $batch) use ($feedSubscription) {
                $feedSubscription->update(['status' => 'pending']);
                event(new FeedSubscriptionUpdated($feedSubscription->refresh()));
            })
            ->then(function (Batch $batch) use ($feedSubscription) {
                $feedSubscription->update(['status' => 'completed']);
                event(new FeedSubscriptionUpdated($feedSubscription->refresh()));
            })
            ->dispatch();

        return $feedSubscription;
    }
}
