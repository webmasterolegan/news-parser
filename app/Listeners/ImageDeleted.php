<?php

namespace App\Listeners;

use App\Events\ImageDeleting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class ImageDeleted
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ImageDeleting $event): void
    {
        logger($event->image->name);
        Storage::delete(config('parser.images_path') . $event->image->name);
    }
}
