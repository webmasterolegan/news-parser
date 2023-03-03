<?php

namespace App\Services;

use Illuminate\Support\Arr;
use App\Contracts\ParserServiceContract;
use App\Utilities\GetRssFeed;

class RssParserService implements ParserServiceContract
{
    const PROCESS_CACHE_KEY = 'parser_in_progress'; // Ключ кеша хранения активности парсера (true/false)
    const PARSER_LOCK_TIME = 120; // Максимальное время хранения данных блокировки парсера

    protected bool $lock;

    public function __construct()
    {
        $this->lock = config('parser.lock');

        if (!$this->lock) return;
        if ($this->lock && cache(self::PROCESS_CACHE_KEY)) {
            throw new \RuntimeException('Другой процесс парсера всё ещё активен');
        }

        cache([self::PROCESS_CACHE_KEY => true], self::PARSER_LOCK_TIME);
    }

    /**
     * Получение массива новостей по URL из XML документа
     */
    public function getNews(string $url): ?array
    {
        $rss_feed = GetRssFeed::data($url);

        if(!$rss_feed) return null;

        $news_list = [];
        foreach ($rss_feed->item as $news) {
            // Получение даты публикации новости
            $published_at = New \DateTime((string)$news->pubDate);
            // Преобразование даты публикации, согласно текущей часовой зоне
            $published_at->setTimezone(new \DateTimeZone(config('app.timezone')));

            // Категория публикации
            $category = strlen((string)$news->category > 0) ? (string)$news->category : null;

            // Авторы новости
            $authors = $news->author ? explode(', ', (string)$news->author) : [];

            // URL обложки новости, если есть
            // Получение тима изображения из xml
            $file_type = (string)$news->enclosure['type'];
            // Проверка допустимых типов
            $image = in_array($file_type, array_keys(config('parser.images_types')))
                ? ['url' => (string)$news->enclosure['url'], 'type' => $file_type]
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

    public function __destruct()
    {
        if (!$this->lock) return;
        cache([self::PROCESS_CACHE_KEY => false], self::PARSER_LOCK_TIME);
    }
}