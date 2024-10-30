<?php

namespace App\Actions\Feed;

use App\Classes\Factories\FeedFactory;
use App\DTOs\FeedDTO;
use App\Models\Feed;
use App\Models\FeedItem;
use Lorisleiva\Actions\Concerns\AsAction;

class AddNewFeed
{
    use AsAction;

    public function handle(FeedDTO $feedDTO, int $user_id): Feed
    {
        $feedContent = file_get_contents($feedDTO->link);
        $feedSource = FeedFactory::create($feedContent);
        $feedSource->extractData($feedContent);

        $feedData = $feedDTO->toArray();
        $feedData['user_id'] = $user_id;

        if (! isset($feedDTO->title)) {
            $feedData['title'] = $feedSource->getTitle();
        }

        if (! isset($feedDTO->description)) {
            $feedData['description'] = $feedSource->getDescription();
        }

        $feed = Feed::create($feedData);

        foreach ($feedSource->getItems() as $item) {
            FeedItem::create([
                'feed_id' => $feed->id,
                'title' => $item->title,
                'guid' => $item->guid,
                'link' => $item->link,
                'description' => $item->description,
                //'pub_date' => $item->getPubDate(),
            ]);
        }

        return $feed;
    }
}
