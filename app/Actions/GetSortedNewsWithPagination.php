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

        $default_attributes = config('parser.news_attributes');
        $default_relations = config('parser.news_relations');

        // Фильтрация атрибутов подходящих для текущего запроса
        $attributes = !empty($r_attributes)
            ? array_intersect($r_attributes, $default_attributes)
            : $default_attributes;

        // Определение атрибутов являющихся связанными моделями
        $relations = !empty($r_attributes)
            ? array_intersect($r_attributes, $default_relations)
            : $default_relations;

        // Добавление id если не указан, но требуется загрузка отношений
        if ($relations && !array_intersect($attributes, ['id'])) {
            $attributes[] = 'id';
        }

        // Сортировка результатов
        $sort = filter_var($request['sort_by_date'], FILTER_VALIDATE_BOOLEAN);
        $order_by = $sort ? 'published_at' : 'id';
        $direction = $sort ? 'desc' : 'asc';

        return News::select(...$attributes)
            ->with($relations)
            ->orderBy($order_by, $direction)
            ->paginate(config('parser.news_on_page'));
    }
}
