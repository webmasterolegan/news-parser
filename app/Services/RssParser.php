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

        $news_collection = collect([]);

        foreach ($rss_feed->channel->item as $item) {
            $news_collection->push(self::parser(item: $item));
        }

        return $news_collection;
    }

    /**
     * Преобразование экземпляра новости к нужному виду
     */
    private function parser(\SimpleXMLElement $item)
    {
        // Получение даты публикации новости
        $published_at = New \DateTime($item->pubDate);
        // Преобразование даты публикации, согласно текущей часовой зоне
        $published_at->setTimezone(new \DateTimeZone(config('app.timezone')));
        // Получение URL изображения
        //$image = (string)$item->children('rbc_news', TRUE)?->image->children('rbc_news', TRUE)?->url;
        $image = $item?->enclosure?->attributes() ? $item?->enclosure?->attributes()[0] : null;
        $image = $image && preg_match(config('parser.images_ext_reg'), $image)
            ? $image
            : null;

        return [
            ...Arr::only((array)$item, ['title', 'description', 'link', 'guid']),
            'published_at' => $published_at,
            'authors' => isset($item->author) ? explode(', ', (string)$item->author) : null,
            'image' => strlen($image) > 0 ? $image : null,
            'category' => (string)$item->category,
        ];
    }
}