<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ParserServiceContract;
use App\Services\RssParserService;

class ParserServiceProvider extends ServiceProvider
{
    public $bindings = [
        ParserServiceContract::class => RssParserService::class,
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
        ];
    }
}
