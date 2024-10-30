<?php

namespace App\Actions\FeedSubscription;

use App\DTOs\FeedDTO;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class AddNewFeedSubscription
{
    use AsAction;

    public function handle(FeedDTO $feedDTO, int $user_id)
    {
        dd($feedDTO, $user_id);
    }

    public function asController(FeedDTO $feedDTO): JsonResponse
    {
        return response()->json([
            'feed' => $this->handle($feedDTO),
        ]);
    }
}
