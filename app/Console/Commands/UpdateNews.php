<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\CollectingDataContract;
use Illuminate\Contracts\Console\Isolatable;
use App\Contracts\AddNewsFromParserContract;

class UpdateNews extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение новостей и сохранение новых';

    /**
     * Получение новостей и сохранение новых.
     */
    public function handle(
        CollectingDataContract $service,
        AddNewsFromParserContract $action
    ): void
    {
        // Получение новых новостей
        $new_news = $service->сollecting(config('parser.rss_feed_url'));

        if (!$new_news) return;

        // Добавление новых новостей (отсортированных по дате пкбликации)
        foreach ($new_news->sortBy('published_at') as $news_data) {
            $action->handle($news_data);
        }
    }
}
