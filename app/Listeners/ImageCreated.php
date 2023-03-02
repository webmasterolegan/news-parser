<?php

namespace App\Listeners;

use App\Events\ImageCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Contracts\DownloadImageContract;

class ImageCreated implements ShouldQueue
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 4;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * Create the event listener.
     */
    public function __construct(
        protected DownloadImageContract $action
    ) {}

    /**
     * Handle the event.
     */
    public function handle(ImageCreate $event): void
    {
        $this->action->handle($event->image->source_url, $event->image->name);
    }
}
