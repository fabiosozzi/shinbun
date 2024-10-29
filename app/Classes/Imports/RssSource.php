<?php

namespace App\Classes\Imports;

use App\Interfaces\FeedSourceInterface;
use App\Traits\HasFeedData;

class RssSource implements FeedSourceInterface
{
    use HasFeedData;

    public function extractData($feedContent): void
    {
        $xml = simplexml_load_string($feedContent, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        $this->title = $array['channel']['title'];

        $this->description = array_key_exists('description', $array['channel']) ? $array['channel']['description'] : '';

        $this->items = array_key_exists('item', $array['channel']) ? $array['channel']['item'] : [];
    }
}
