<?php

namespace App\Classes\Imports;

use App\Interfaces\FeedSourceInterface;
use App\Traits\HasFeedData;

class AtomSource implements FeedSourceInterface
{
    use HasFeedData;

    public function extractData($feedContent): void
    {

        $xml = simplexml_load_string($feedContent, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        $this->items = $array;
    }
}
