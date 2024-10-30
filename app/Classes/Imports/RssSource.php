<?php

namespace App\Classes\Imports;

use App\DTOs\FeedItemDTO;
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

        $items = [];
        if (array_key_exists('item', $array['channel'])) {
            foreach ($array['channel']['item'] as $item) {
                $items[] = new FeedItemDTO([
                    'title' => $item['title'],
                    'guid' => $item['guid'],
                    'link' => $item['link'],
                    'description' => $item['description'],
                    'pub_date' => date('Y-m-d H:i:s', strtotime($array['channel']['pubDate'])),
                ]);
            }
        }

        $this->items = $items;
    }
}
