<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ParserServiceContract;
use App\Services\ParserService;
use App\Contracts\AddNewsFromParserContract;
use App\Actions\AddNewsFromParser;
use App\Contracts\CollectingDataContract;
use App\Services\CollectingNews;
use App\Contracts\DownloadImageContract;
use App\Services\DownloadImage;
use App\Contracts\GetSortedNewsWithPaginationContract;
use App\Actions\GetSortedNewsWithPagination;
use App\Contracts\ParserContract;
use App\Services\RssParser;

class ParserServiceProvider extends ServiceProvider
{
    public $bindings = [
        ParserContract::class => RssParser::class,
        ParserServiceContract::class => ParserService::class,
        AddNewsFromParserContract::class => AddNewsFromParser::class,
        CollectingDataContract::class => CollectingNews::class,
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
            ParserContract::class,
            ParserServiceContract::class,
            AddNewsFromParserContract::class,
            CollectingDataContract::class,
            DownloadImageContract::class,
            GetSortedNewsWithPaginationContract::class,
        ];
    }
}
