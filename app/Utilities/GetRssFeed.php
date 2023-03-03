<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Http;

class GetRssFeed
{
    public static function data(string $url): \SimpleXMLElement|false
    {
        $response = Http::get($url);

        if (!$response->successful()) return false;

        $rss_feed = simplexml_load_string($response->body());

        if (!$rss_feed) return false;

        return $rss_feed->channel;
    }
}