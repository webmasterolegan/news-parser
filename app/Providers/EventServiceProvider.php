<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ImageCreate;
use App\Listeners\ImageCreated;
use App\Events\ImageDeleting;
use App\Listeners\ImageDeleted;
use App\Listeners\ParserRequestLogger;
use App\Models\News;
use App\Observers\NewsObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ImageCreate::class => [
            ImageCreated::class,
        ],
        ImageDeleting::class => [
            ImageDeleted::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        ParserRequestLogger::class,
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        News::class => [NewsObserver::class],
    ];
}
