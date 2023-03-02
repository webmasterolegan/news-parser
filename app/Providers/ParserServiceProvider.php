<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ParserServiceContract;
use App\Services\RssParserService;
use App\Contracts\AddNewsFromParserContract;
use App\Actions\AddNewsFromParser;

class ParserServiceProvider extends ServiceProvider
{
    public $bindings = [
        ParserServiceContract::class => RssParserService::class,
        AddNewsFromParserContract::class => AddNewsFromParser::class,
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
        ];
    }
}
