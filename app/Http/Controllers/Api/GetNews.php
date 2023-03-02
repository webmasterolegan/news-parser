<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\NewsResource;
use App\Contracts\GetSortedNewsWithPaginationContract;

class GetNews
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        GetSortedNewsWithPaginationContract $action,
        Request $request
    )
    {
        return NewsResource::collection($action->handle($request));
    }
}
