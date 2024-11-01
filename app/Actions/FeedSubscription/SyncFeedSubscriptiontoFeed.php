<?php

namespace App\Actions\FeedSubscription;

use App\Models\Feed;
use Illuminate\Bus\Batch;
use App\Models\FeedSubscription;
use Illuminate\Support\Facades\Bus;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Jobs\FeedSubscription\SyncFeedSubscriptionItemsToFeedItemsJob;

class SyncFeedSubscriptiontoFeed
{
    use AsAction;

    public function handle(Feed $feed, FeedSubscription $feedSubscription): FeedSubscription
    {
        $array_batch_calls = [];
        
        $feed->feed_items->chunk(config('feeds.chunk_size_items_import'))->each(function ($items) use ($feedSubscription, &$array_batch_calls) {
            $array_batch_calls[] = new SyncFeedSubscriptionItemsToFeedItemsJob($feedSubscription, $items);
        });

        Bus::batch($array_batch_calls)
            ->before(function (Batch $batch) use ($feedSubscription) {
                $feedSubscription->update(['status' => 'pending']);
            })
            ->then(function (Batch $batch) use ($feedSubscription) {
                $feedSubscription->update(['status' => 'completed']);
            })
            ->dispatch();

        return $feedSubscription;
    }
}
