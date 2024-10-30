<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class FeedItemDTO extends ValidatedDTO
{
    public string $title;

    public string $guid;

    public string $link;

    public string $description;

    public string $pub_date;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'guid' => ['required', 'string'],
            'link' => ['required', 'string'],
            'description' => ['required', 'string'],
            //'pub_date' => ['required', 'string'],
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
