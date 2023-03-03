<?php

namespace App\Listeners;

use App\Events\NewsCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class NewsCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewsCreate $event): void
    {
        // Обновление кеша уже существующих ссылок
        $cache_key = config('parser.links_cache_key');
        $isset_news = Cache::get($cache_key);
        $isset_news[] = $event->news->link;
        Cache::forever($cache_key, $isset_news);
    }
}
