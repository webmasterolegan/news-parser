<?php

namespace App\Actions;

use App\Contracts\AddNewsFromParserContract;
use App\Models\News;
use App\Models\Author;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AddNewsFromParser implements AddNewsFromParserContract
{
    /**
     * Добавление новости в базу из массива сервиса парсера (App\Services\RssParser)
     */
    public function handle(array $news_data): bool
    {
        $news = News::create(Arr::only($news_data, [
            'link',
            'title',
            'description',
            'published_at'
        ]));

        if (!$news) return false;

        // Добавление авторов новости если указаны
        if ($news_data['authors']) {
            foreach ($news_data['authors'] as $author_name) {
                $author = Author::firstOrCreate(['name' => $author_name]);
                $news->authors()->attach($author->id);
            }
        }

        // Добавление файла изображения если указаны
        if ($news_data['image']) {
            $image_extention = match($news_data['image']['type']) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                'image/gif' => 'gif',
            };

            $image_name =  Str::random(32) . '.' . $image_extention;

            $news->image()->create([
                'news_id' => $news->id,
                'source_url' => $news_data['image']['url'],
                'name' => $image_name ,
            ]);
        }

        return true;
    }
}
