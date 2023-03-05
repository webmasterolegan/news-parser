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

        $default_attributes = ['title', 'description', 'published_at'];
        $default_relations = ['image', 'authors'];

        $sort = filter_var($request['sort_by_date'], FILTER_VALIDATE_BOOLEAN);
        $order_by = $sort ? 'published_at' : 'id';
        $direction = $sort ? 'desc' : 'asc';

        $attributes = $r_attributes
            ? array_intersect($default_attributes, $r_attributes)
            : $default_attributes;

        $relations = $r_attributes
            ? array_intersect($default_relations, $r_attributes)
            : $default_relations;

        $attributes[] = 'id';

        return News::select(...$attributes)
            ->with($relations)
            ->orderBy($order_by, $direction)
            ->paginate(config('parser.news_on_page'));
    }
}
