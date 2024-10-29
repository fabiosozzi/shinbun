<?php

namespace App\Classes\Factories;

use App\Classes\Imports\AtomSource;
use App\Classes\Imports\RssSource;
use Exception;

class FeedFactory
{
    public static function create($feedContent)
    {
        if (strpos($feedContent, '<rss') !== false) {
            return new RssSource;
        } elseif (strpos($feedContent, '<feed') !== false) {
            return new AtomSource;
        } else {
            throw new Exception('Feed type not recognized');
        }
    }
}
