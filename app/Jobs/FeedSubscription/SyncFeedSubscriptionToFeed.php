<?php

namespace App\Jobs\FeedSubscription;

use App\Models\Feed;
use App\Models\FeedSubscription;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class SyncFeedSubscriptionToFeed implements ShouldQueueAfterCommit
{
    use InteractsWithQueue, Queueable;

    public $backoff = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(private Feed $feed, private FeedSubscription $feedSubscription) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->feed->feed_items->chunk(config('feeds.chunk_size_items_import'))->each(function ($items) {
            $items->each(function ($item) {
                $this->feedSubscription->feed_subscription_items()->create([
                    'title' => $item->title,
                    'guid' => $item->guid,
                    'link' => $item->link,
                    'description' => $item->description,
                    'pub_date' => $item->pub_date,
                ]);
            });
        });
    }
}
