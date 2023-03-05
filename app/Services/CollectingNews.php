<?php

namespace App\Services;

use App\Contracts\CollectingDataContract;
use App\Contracts\ParserServiceContract;
use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class CollectingNews implements CollectingDataContract
{
    public function __construct(
        private ParserServiceContract $parser
    ) {}

    /**
     * Выборка новых новостей из RSS
     */
    public function сollecting(string $url): ?Collection
    {
        // Все новости, в массиве остортированном по дате публикации (published_at)
        $news_from_rss_feed = $this->parser->getData(url: $url);

        if (!$news_from_rss_feed) return null;

        // Список ссылок имеющихся новостей, если нету в кэше, то попросим все ссылки у модели
        $isset_links = Cache::rememberForever(
            config('parser.links_cache_key'),
            fn () => News::pluck('link')->toArray()
        );

        //!!

        return $news_from_rss_feed;
    }
}