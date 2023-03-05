<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface ParserContract
{
    public function extract(string $body): ?Collection;
}