<?php

namespace App\Traits;

trait HasFeedData
{
    private $title;

    private $description;

    private $items;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
