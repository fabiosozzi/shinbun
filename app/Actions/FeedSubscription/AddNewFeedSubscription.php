<?php

namespace App\Actions\FeedSubscription;

use App\Actions\Feed\AddNewFeed;
use App\DTOs\FeedDTO;
use App\DTOs\FeedSubscriptionDTO;
use App\Models\Feed;
use App\Models\FeedSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class AddNewFeedSubscription
{
    use AsAction;

    public function handle(FeedDTO $feedDTO, int $user_id)
    {
        $existingFeed = Feed::where('link', $feedDTO->link)->first();
        if (! $existingFeed) {
            $existingFeed = AddNewFeed::run($feedDTO);
        }

        $feed_data_array = $feedDTO->toArray();
        $feed_data_array['user_id'] = $user_id;

        $feed_subscription_dto = new FeedSubscriptionDTO($feed_data_array);

        $feed_subscription_array = $feed_subscription_dto->toArray();

        if (! isset($feedDTO->title)) {
            $feed_subscription_array['title'] = $existingFeed->title;
        }

        if (! isset($feedDTO->description)) {
            $feed_subscription_array['description'] = $existingFeed->description;
        }

        $feed_subscription = FeedSubscription::create($feed_subscription_array);

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
