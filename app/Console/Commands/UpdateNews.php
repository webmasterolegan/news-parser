<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\CollectingNewNewsContract;
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
    protected $description = 'Получение и сохранение новостей';

    /**
     * Execute the console command.
     */
    public function handle(
        CollectingNewNewsContract $service,
        AddNewsFromParserContract $action
    ): void
    {
        // Получение новых новостей
        $new_news = $service->getNewNews(config('parser.rss_feed_url'));

        if (!$new_news) return;

        // Добавление новых новостей
        foreach ($new_news as $news_data) {
            $action->handle($news_data);
        }
    }
}
