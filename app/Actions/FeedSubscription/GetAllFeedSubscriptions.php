<?php

namespace App\Actions\FeedSubscription;

use App\Http\Resources\FeedSubscription\FeedSubscriptionListResource;
use App\Models\FeedSubscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllFeedSubscriptions
{
    use AsAction;

    public function handle(int $user_id): Collection
    {
        return FeedSubscription::whereHas('user', function (Builder $query) use ($user_id) {
            $query->where('id', $user_id);
        })->get();
    }

    public function asController(Request $request): JsonResponse
    {
        // TODO: must include pagination?
        
        $user_id = $request->user()->id;

        return response()->json([
            'feeds' => FeedSubscriptionListResource::collection($this->handle($user_id)),
        ]);
    }
}
