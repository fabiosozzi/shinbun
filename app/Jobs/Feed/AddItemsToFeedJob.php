<?php

namespace App\Jobs\Feed;

use Exception;
use App\Models\Feed;
use App\Models\FeedItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddItemsToFeedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $items) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->items as $item) {
            try {
                FeedItem::create([
                    'feed_id' => $item['feed_id'],
                    'title' => $item['title'],
                    'guid' => $item['guid'],
                    'link' => $item['link'],
                    'description' => $item['description'],
                    'pub_date' => $item['pub_date'],
                ]);
            }
            catch(Exception $e) {
                Log::alert($e->getMessage());
            }
            
        }
    }
}
