<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\NewsResource;
use App\Contracts\GetSortedNewsWithPaginationContract;

class GetNews
{
    /**
     * @LRDparam attributes string|nullable
     * @LRDparam sort_by_date true|nullable
     * @lrd:start
     * В качестве значения аргумента **attributes** используется перечисление атрибутов через запятую.
     *
     * Пример: **attributes=id,title,description,published_at,authors,image**
     *
     * Если атрибуты не указаны, будет возвращён JSON с атрибутами как в примере *(id,title,description,published_at,authors,image)*.
     *
     * @lrd:end
     */
    public function __invoke(
        GetSortedNewsWithPaginationContract $action,
        Request $request
    )
    {
        return NewsResource::collection($action->handle($request));
    }
}
