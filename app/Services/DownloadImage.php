<?php

namespace App\Services;

use App\Contracts\DownloadImageContract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class DownloadImage implements DownloadImageContract
{
    /**
     * Скачивание файлов изображений
     */
    public function handle(string $url, string $name): bool
    {
        $response = Http::get($url);
        if (!$response->successful()) return false;
        Storage::put('images/' . $name, $response->body());
        return true;
    }
}
