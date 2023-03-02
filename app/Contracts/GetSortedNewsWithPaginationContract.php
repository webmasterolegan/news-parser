<?php

namespace App\Contracts;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GetSortedNewsWithPaginationContract
{
    public function handle(Request $request): LengthAwarePaginator;
}