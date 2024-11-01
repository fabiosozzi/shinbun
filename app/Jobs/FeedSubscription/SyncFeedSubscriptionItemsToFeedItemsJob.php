<?php

namespace App\Jobs\FeedSubscription;

use App\Models\Feed;
use Illuminate\Bus\Batchable;
use App\Models\FeedSubscription;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Database\Eloquent\Collection;

class SyncFeedSubscriptionItemsToFeedItemsJob implements ShouldQueueAfterCommit
{
    use Batchable, InteractsWithQueue, Queueable;

    public $backoff = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(private FeedSubscription $feedSubscription, private Collection $items) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // TODO: implement UPSERT function to avoid duplicates
        $this->items->each(function ($item) {
            $this->feedSubscription->feed_subscription_items()->create([
                'title' => $item->title,
                'guid' => $item->guid,
                'link' => $item->link,
                'description' => $item->description,
                'pub_date' => $item->pub_date,
            ]);
        });
    }
}
