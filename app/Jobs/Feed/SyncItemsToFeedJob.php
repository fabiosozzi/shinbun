<?php

namespace App\Jobs\Feed;

use App\Models\FeedItem;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class SyncItemsToFeedJob implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $items) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        FeedItem::upsert(
            $this->items,
            ['feed_id', 'guid'],
            ['title', 'link', 'description', 'pub_date']
        );
    }
}
