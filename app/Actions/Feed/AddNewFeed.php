<?php

namespace App\Actions\Feed;

use App\Classes\Factories\FeedFactory;
use App\DTOs\FeedDTO;
use App\Events\Feed\FeedSuccessfullyReloaded;
use App\Jobs\Feed\AddItemsToFeedJob;
use App\Models\Feed;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Lorisleiva\Actions\Concerns\AsAction;

class AddNewFeed
{
    use AsAction;

    public function handle(FeedDTO $feedDTO): Feed
    {
        $feedContent = file_get_contents($feedDTO->link);
        $feedSource = FeedFactory::create($feedContent);

        // TODO: is it possibile to extract only title and description from the feed source?
        $feedSource->extractData($feedContent);

        $feedData = $feedDTO->toArray();

        if (! isset($feedDTO->title)) {
            $feedData['title'] = $feedSource->getTitle();
        }

        if (! isset($feedDTO->description)) {
            $feedData['description'] = $feedSource->getDescription();
        }

        $feed = Feed::create($feedData);

        $array_batch_calls = [];

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

            $array_batch_calls[] = new AddItemsToFeedJob($array_items);
        });

        Bus::batch($array_batch_calls)
            ->then(function (Batch $batch) use ($feed) {
                $feed->update(['status' => 'completed']);
                FeedSuccessfullyReloaded::dispatch($feed);
            })
            ->dispatch();

        return $feed;
    }
}
