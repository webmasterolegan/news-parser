<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface CollectingDataContract
{
    public function сollecting(string $url): ?Collection;
}