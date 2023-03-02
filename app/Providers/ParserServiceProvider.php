<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ParserServiceContract;
use App\Services\RssParserService;
use App\Contracts\AddNewsFromParserContract;
use App\Actions\AddNewsFromParser;
use App\Contracts\CollectingNewNewsContract;
use App\Services\CollectingNewNews;
use App\Contracts\DownloadImageContract;
use App\Services\DownloadImage;
use App\Contracts\GetSortedNewsWithPaginationContract;
use App\Actions\GetSortedNewsWithPagination;

class ParserServiceProvider extends ServiceProvider
{
    public $bindings = [
        ParserServiceContract::class => RssParserService::class,
        AddNewsFromParserContract::class => AddNewsFromParser::class,
        CollectingNewNewsContract::class => CollectingNewNews::class,
        DownloadImageContract::class => DownloadImage::class,
        GetSortedNewsWithPaginationContract::class => GetSortedNewsWithPagination::class,
    ];

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            ParserServiceContract::class,
            AddNewsFromParserContract::class,
            CollectingNewNewsContract::class,
            DownloadImageContract::class,
            GetSortedNewsWithPaginationContract::class,
        ];
    }
}
