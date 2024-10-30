<?php

namespace App\Actions\Feed;

use App\Classes\Factories\FeedFactory;
use App\DTOs\FeedDTO;
use App\Jobs\Feed\AddItemsToFeedJob;
use App\Models\Feed;
use Lorisleiva\Actions\Concerns\AsAction;

class AddNewFeed
{
    use AsAction;

    public function handle(FeedDTO $feedDTO): Feed
    {
        $feedContent = file_get_contents($feedDTO->link);
        $feedSource = FeedFactory::create($feedContent);
        $feedSource->extractData($feedContent);

        $feedData = $feedDTO->toArray();

        if (! isset($feedDTO->title)) {
            $feedData['title'] = $feedSource->getTitle();
        }

        if (! isset($feedDTO->description)) {
            $feedData['description'] = $feedSource->getDescription();
        }

        $feed = Feed::create($feedData);
        
        collect($feedSource->getItems())->chunk(50)->each(function ($items) use ($feed) {
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

            dispatch(new AddItemsToFeedJob($array_items));
        });

        return $feed;
    }
}
