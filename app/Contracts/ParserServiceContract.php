<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface ParserServiceContract
{
    public function getData(string $url): ?Collection;
}