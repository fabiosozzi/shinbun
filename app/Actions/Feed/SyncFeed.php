<?php

namespace App\Actions\Feed;

use App\Classes\Factories\FeedFactory;
use App\Events\Feed\FeedSuccessfullyReloaded;
use App\Jobs\Feed\SyncItemsToFeedJob;
use App\Models\Feed;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncFeed
{
    use AsAction;

    public function handle(Feed $feed)
    {
        $feedContent = file_get_contents($feed->link);
        $feedSource = FeedFactory::create($feedContent);
        $feedSource->extractData($feedContent);

        collect($feedSource->getItems())->chunk(size: config('feeds.chunk_size_items_import'))->each(function ($items) use ($feed, &$array_batch_calls) {
            $array_items = [];
            $items->each(function ($item) use ($feed, &$array_items) {
                $array_items[] = [
                    'feed_id' => $feed->id,
                    'title' => $item->title,
                    'guid' => $item->guid,
                    'link' => $item->link,
                    'description' => $item->description,
                    'pub_date' => $item->pub_date,
                ];
            });

            $array_batch_calls[] = new SyncItemsToFeedJob($array_items);

            Bus::batch($array_batch_calls)
                ->then(function (Batch $batch) use ($feed) {
                    $feed->update(['status' => 'completed']);
                    FeedSuccessfullyReloaded::dispatch($feed);
                })
                ->dispatch();
        });
    }
}
