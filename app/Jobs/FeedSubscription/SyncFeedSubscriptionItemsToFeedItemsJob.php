<?php

namespace App\Jobs\FeedSubscription;

use App\Models\FeedSubscription;
use App\Models\FeedSubscriptionItem;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class SyncFeedSubscriptionItemsToFeedItemsJob implements ShouldQueueAfterCommit
{
    use Batchable, InteractsWithQueue, Queueable;

    public $backoff = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(private FeedSubscription $feedSubscription, private array $items) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        FeedSubscriptionItem::upsert(
            $this->items,
            ['feed_subscription_id', 'guid'],
            ['title', 'link', 'description', 'pub_date']
        );
    }
}
