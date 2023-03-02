<?php

namespace App\Services;

use Illuminate\Support\Arr;
use App\Contracts\ParserServiceContract;
use App\Utilities\GetRssFeed;

class RssParserService implements ParserServiceContract
{
    public function getNews(string $url): ?array
    {
        $rss_feed = GetRssFeed::data($url);

        $news_list = [];
        foreach ($rss_feed->item as $news) {
            // Получение даты публикации новости
            $published_at = New \DateTime((string)$news->pubDate);
            // Преобразование даты публикации, согласно текущей часовой зоне
            $published_at->setTimezone(new \DateTimeZone(config('app.timezone')));
            // Категория публикации
            $category = strlen((string)$news->category > 0)
                ? (string)$news->category
                : null;

            // Авторы новости, если указаны
            $authors = $news->author
                ? explode(', ', (string)$news->author)
                : null;

            // URL обложки новости, если есть
            $file_type = (string)$news->enclosure['type'];
            $image = in_array($file_type, [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
            ])
                ? [
                    'url' => (string)$news->enclosure['url'],
                    'type' => $file_type,
                ]
                : null;

            // Подготовка возвращаемого экземпляра новости
            $news_list[] = [
                'link' => (string)$news->link,
                'title' => (string)$news->title,
                'description' => (string)$news->description,
                'published_at' => $published_at,
                'authors' => $authors,
                'image' => $image,
                'category' => $category,
                'guid' => (string)$news->guid,
            ];
        }

        // Возвращение сортированных новостей, по дате публикации
        return array_values(Arr::sort(
            $news_list,
            fn (array $value): \DateTime => $value['published_at']
        ));
    }
}