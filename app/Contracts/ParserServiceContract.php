<?php

namespace App\Contracts;

interface ParserServiceContract
{
    public function getNews(string $url): ?array;
}