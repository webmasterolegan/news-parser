<?php

namespace App\Contracts;

interface DownloadImageContract
{
    public function handle(string $url, string $name): bool;
}