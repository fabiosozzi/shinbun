<?php

namespace App\Actions\FeedSubscription;

use App\Models\Feed;
use App\DTOs\FeedDTO;
use Illuminate\Http\Request;
use App\Actions\Feed\AddNewFeed;
use App\Models\FeedSubscription;
use App\DTOs\FeedSubscriptionDTO;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class AddNewFeedSubscription
{
    use AsAction;

    public function handle(FeedDTO $feedDTO, int $user_id)
    {
        $feed = Feed::where('link', $feedDTO->link)->first();
        if (! $feed) {
            $feed = AddNewFeed::run($feedDTO);
        }

        $feed_data_array = $feedDTO->toArray();
        $feed_data_array['feed_id'] = $feed->id;
        $feed_data_array['user_id'] = $user_id;

        if (! isset($feedDTO->title)) {
            $feed_data_array['title'] = $feed->title;
        }

        if (! isset($feedDTO->description)) {
            $feed_data_array['description'] = $feed->description;
        }

        $feed_subscription_dto = new FeedSubscriptionDTO($feed_data_array);
        $feed_subscription = FeedSubscription::create($feed_subscription_dto->toArray());

        //SyncFeedSubscriptiontoFeed::run($feed, $feed_subscription);

        return $feed_subscription;
    }

    public function asController(Request $request, FeedDTO $feedDTO): JsonResponse
    {
        $user_id = $request->user()->id;

        return response()->json([
            'feed' => $this->handle($feedDTO, $user_id),
        ]);
    }
}
