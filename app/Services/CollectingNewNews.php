<?php

namespace App\Services;

use App\Contracts\CollectingNewNewsContract;
use App\Contracts\ParserServiceContract;
use App\Models\News;
use Illuminate\Support\Facades\Cache;

class CollectingNewNews implements CollectingNewNewsContract
{
    public function __construct(
        private ParserServiceContract $parser
    ) {}

    /**
     * Выборка и добавление новых новостей из RSS
     */
    public function getNewNews(string $url): ?array
    {
        // Все новости, в массиве остортированном по дате публикации (published_at)
        $news_from_rss_feed = $this->parser->getNews($url);
        if (!$news_from_rss_feed) return null;

        // Список ссылок имеющихся новостей
        $isset_links = Cache::rememberForever(
            config('parser.links_cache_key'),
            fn () => News::pluck('link')->toArray()
        );

        // Отсеивание новостей уже имеющихся в базе (по полю link)
        $new_news = array_values(array_filter($news_from_rss_feed, fn (array $news_data): bool =>
            !in_array($news_data['link'], $isset_links)
        ));

        return $new_news;
    }
}