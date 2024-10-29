<?php

namespace App\Actions\Feed;

use App\Http\Resources\Feed\FeedListResource;
use App\Models\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllFeeds
{
    use AsAction;

    public function handle(int $user_id): Collection
    {
        return Feed::with('items')->whereHas('user', function (Builder $query) use ($user_id) {
            $query->where('id', $user_id);
        })->get();
    }

    public function asController(Request $request): JsonResponse
    {
        $user_id = $request->user()->id;

        return response()->json([
            'feeds' => FeedListResource::collection($this->handle($user_id)),
        ]);
    }
}
