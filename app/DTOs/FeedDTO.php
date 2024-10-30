<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class FeedDTO extends ValidatedDTO
{
    public string $title;

    public string $link;

    public string $description;

    public string $language;

    protected function rules(): array
    {
        return [
            'title' => ['string'],
            'link' => ['required', 'string'],
            'description' => ['string'],
            'language' => ['string'],
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
