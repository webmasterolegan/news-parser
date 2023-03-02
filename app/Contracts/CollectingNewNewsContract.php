<?php

namespace App\Contracts;

interface CollectingNewNewsContract
{
    public function getNewNews(string $url): ?array;
}