<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Http;

class GetRssFeed
{
    public static function data(string $url)
    {
        $response = Http::get($url);

        if ($response->failed()) return null;

        $rss_feed = simplexml_load_string($response->body());

        if (!$rss_feed?->channel?->item) return null;

        return $rss_feed->channel;
    }
}