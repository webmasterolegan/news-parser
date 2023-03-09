<?php

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Facades\Cache;

class NewsObserver
{
    private string $cache_key;
    private array $cache_news_links;

    public function __construct()
    {
        $this->cache_key = config('parser.links_cache_key');
        $this->cache_news_links = (array)Cache::get($this->cache_key);
    }

    /**
     * Handle the News "created" event.
     */
    public function created(News $news): void
    {
        // Обновление кеша уже существующих ссылок
        $this->cache_news_links[] = $news->link;
        Cache::forever($this->cache_key, $this->cache_news_links);
    }

    /**
     * Handle the News "updated" event.
     */
    public function updated(News $news): void
    {
        //
    }

    /**
     * Handle the News "deleted" event.
     */
    public function deleted(News $news): void
    {
        unset($this->cache_news_links[array_search($news->link, $this->cache_news_links)]);
        Cache::forever($this->cache_key, $this->cache_news_links);
    }

    /**
     * Handle the News "restored" event.
     */
    public function restored(News $news): void
    {
        //
    }

    /**
     * Handle the News "force deleted" event.
     */
    public function forceDeleted(News $news): void
    {
        //
    }
}
