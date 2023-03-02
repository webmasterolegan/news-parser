<?php

namespace App\Contracts;

interface AddNewsFromParserContract
{
    public function handle(array $news): bool;
}