<?php

namespace App\Actions\FeedSubscription;

use App\Http\Resources\FeedSubscription\FeedSubscriptionItemContentResource;
use App\Models\FeedSubscriptionItem;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSpecificFeedSubscriptionItem
{
    use AsAction;

    public function handle($feed_subscription_item_id): FeedSubscriptionItem
    {
        return FeedSubscriptionItem::find($feed_subscription_item_id);
    }

    public function asController(Request $request)
    {
        // TODO: check that the item belongs to the user
        
        return response()->json([
            'news' => new FeedSubscriptionItemContentResource($this->handle($request->feed_subscription_item_id)),
        ]);
    }
}
