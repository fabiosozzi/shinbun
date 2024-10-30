<?php

namespace App\Actions\FeedSubscription;

use App\Models\FeedSubscriptionItem;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllItemsFromFeedSubscriptions
{
    use AsAction;

    public function handle(int $feed_subscription_id)
    {
        return FeedSubscriptionItem::whereHas('feed_subscription', function ($query) use ($feed_subscription_id) {
            $query->where('id', $feed_subscription_id);
        })->get();
    }

    public function asController(Request $request)
    {
        // TODO: must include pagination?

        return response()->json([
            'news' => $this->handle($request->feed_subscription_id),
        ]);
    }
}
