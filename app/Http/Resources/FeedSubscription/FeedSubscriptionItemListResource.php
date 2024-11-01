<?php

namespace App\Http\Resources\FeedSubscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class FeedSubscriptionItemListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pub_date = new DateTime($this->pub_date);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'pub_date' => $pub_date->format('Y-m-d H:i:s'),
        ];
    }
}
