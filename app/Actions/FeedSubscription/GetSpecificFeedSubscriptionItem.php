<?php

namespace App\Actions\FeedSubscription;

use App\Http\Resources\FeedSubscription\FeedSubscriptionItemContentResource;
use App\Models\FeedItem;
use App\Models\FeedSubscriptionItem;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSpecificFeedSubscriptionItem
{
    use AsAction;

    public function handle($feed_subscription_item_id): FeedItem
    {
        return FeedSubscriptionItem::find($feed_subscription_item_id);
    }

    public function asController(Request $request)
    {
        return response()->json([
            'news' => new FeedSubscriptionItemContentResource($this->handle($request->feed_subscription_item_id)),
        ]);
    }
}
