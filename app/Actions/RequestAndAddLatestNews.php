<?php

namespace App\Actions;

use App\Contracts\RequestAndAddLatestNewsContract;
use App\Contracts\ParserServiceContract;
use App\Contracts\AddNewsFromParserContract;
use App\Models\News;

class RequestAndAddLatestNews implements RequestAndAddLatestNewsContract
{
    public function __construct(
        private ParserServiceContract $parser,
        private AddNewsFromParserContract $action
    ) {}

    /**
     * Выборка и добавление новых новостей из RSS
     */
    public function handle(): void
    {
        // Все новости, в массиве остортированном по дате публикации (published_at)
        $news_from_rss_feed = $this->parser->getNews(config('parser.rss_feed_url'));
        if (count($news_from_rss_feed) == 0) return;
        // Список ссылок имеющихся новостей
        $isset_links = News::pluck('link')->toArray();
        // Отсеивание новостей уже имеющихся в базе (по полю link)
        $news_to_add = array_values(array_filter($news_from_rss_feed, fn (array $news_data): bool =>
            !in_array($news_data['link'], $isset_links)
        ));
        // Добавление не имеющихся новостей
        foreach ($news_to_add as $news_data) {
            $this->action->handle($news_data);
        }
    }
}