<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Contracts\ParserContract;
use Illuminate\Support\Arr;

class RssParser implements ParserContract
{
    /**
     * Разбор RSS ленты
     */
    public function extract(string $body): ?Collection
    {
        $rss_feed = simplexml_load_string($body);
        if (!$rss_feed) return null;

        $news_collection = collect(json_decode(json_encode($rss_feed->channel), true)['item']);
        $news_collection->transform(fn (array $item): array => self::parser(item: $item));

        return $news_collection;
    }

    /**
     * Преобразование экземпляра новости к нужному виду
     */
    private function parser(array $item)
    {
        // Получение даты публикации новости
        $published_at = New \DateTime($item['pubDate']);
        // Преобразование даты публикации, согласно текущей часовой зоне
        $published_at->setTimezone(new \DateTimeZone(config('app.timezone')));

        // Получение изображения новости, если есть
        if (array_key_exists('enclosure', $item)
            && array_key_exists('type', $item['enclosure'])
            && array_key_exists('url', $item['enclosure'])
        ) {
            $image = Arr::first(
                $item['enclosure'],
                // Первый элемент с соответствующим типом изображения
                fn (array $media): bool => in_array($media['type'], array_keys(config('parser.images_types')))
            );
        }

        return [
            ...Arr::only($item, ['title', 'description', 'link', 'guid']),
            'published_at' => $published_at,
            'authors' => isset($item['author']) ? explode(', ', $item['author']) : null,
            'image' => $image ?? null,
            'category' => strlen($item['category'] > 0) ? $item['category'] : null,
        ];
    }
}