<?php

namespace App\Interfaces;

interface FeedSourceInterface
{
    public function extractData(string $feedContent): void;

    public function getTitle(): string;

    public function getDescription(): string;

    public function getItems(): array;
}
