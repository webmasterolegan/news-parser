<?php

namespace App\Actions;

use App\Models\News;
use App\Contracts\GetSortedNewsWithPaginationContract;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Utilities\GetAttributesFromRequest;

class GetSortedNewsWithPagination implements GetSortedNewsWithPaginationContract
{
    /**
     *   Получение из базы данных отсортированных новостей с постраничной разбивкой
     */
    public function handle(Request $request): LengthAwarePaginator
    {
        $r_attributes = GetAttributesFromRequest::data($request);

        $sort = filter_var($request['sort_by_date'], FILTER_VALIDATE_BOOLEAN);
        $order_by = $sort ? 'published_at' : 'id';
        $direction = $sort ? 'desc' : 'asc';

        $attributes = array_intersect(['title', 'description', 'published_at'], $r_attributes);
        $attributes[] = 'id';
        $relations = array_intersect(['image', 'authors'], $r_attributes);

        return News::select(...$attributes)
            ->with($relations)
            ->orderBy($order_by, $direction)
            ->paginate(config('parser.news_on_page'));
    }
}
