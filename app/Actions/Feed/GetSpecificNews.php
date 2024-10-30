<?php

namespace App\Actions\Feed;

use App\Http\Resources\Feed\FeedItemContentResource;
use App\Models\FeedItem;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSpecificNews
{
    use AsAction;

    public function handle($feed_id): FeedItem
    {
        return FeedItem::find($feed_id);
    }

    public function asController(Request $request)
    {
        return response()->json([
            'news' => new FeedItemContentResource($this->handle($request->feed_item)),
        ]);
    }
}
