<?php

namespace App\Actions\Feed;

use App\Models\FeedItem;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllNewsFromFeed
{
    use AsAction;

    public function handle(int $feed_id)
    {
        return FeedItem::whereHas('feed', function ($query) use ($feed_id) {
            $query->where('id', $feed_id);
        })->get();
    }

    public function asController(Request $request)
    {
        return response()->json([
            'news' => $this->handle($request->feed),
        ]);
    }
}
