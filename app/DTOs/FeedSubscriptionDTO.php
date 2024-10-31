<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class FeedSubscriptionDTO extends ValidatedDTO
{
    public string $title;

    public string $link;

    public string $description;

    public string $language;

    public int $user_id;

    public int $feed_id;

    protected function rules(): array
    {
        return [
            'title' => ['string'],
            'description' => ['string'],
            'link' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
            'feed_id' => ['required', 'integer'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
