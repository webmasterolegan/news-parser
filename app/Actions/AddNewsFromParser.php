<?php

namespace App\Actions;

use App\Contracts\AddNewsFromParserContract;
use App\Models\News;
use App\Models\Author;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Category;

class AddNewsFromParser implements AddNewsFromParserContract
{
    /**
     * Добавление экземпляра новости из парсера в базу
     */
    public function handle(array $news_data): bool
    {
        $category = Category::firstOrCreate(['name' => $news_data['category']]);

        $news = News::create([
            'category_id' => $category->id,
            ...Arr::only($news_data, [
                'link',
                'title',
                'description',
                'published_at'
            ])
        ]);

        if (!$news->exists) return false;

        // Добавление авторов новости
        if ($news_data['authors']) {
            foreach ($news_data['authors'] as $author_name) {
                $author = Author::firstOrCreate(['name' => $author_name]);
                $news->authors()->attach($author->id);
            }
        }

        // Добавление файла изображения если указаны
        if ($news_data['image']) {
            $extention = Str::of($news_data['image'])->match(config('parser.images_ext_reg'));
            $image_name =  Str::random(32) . '.' . $extention;

            $news->image()->create([
                'news_id' => $news->id,
                'source_url' => $news_data['image'],
                'name' => $image_name ,
            ]);
        }

        return true;
    }
}
