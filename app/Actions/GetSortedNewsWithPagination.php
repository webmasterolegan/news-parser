<?php

namespace App\Actions;

use App\Models\News;
use App\Contracts\GetSortedNewsWithPaginationContract;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetSortedNewsWithPagination implements GetSortedNewsWithPaginationContract
{
    /**
     *   Получение из базы данных отсортированных новостей с постраничной разбивкой
     */
    public function handle(Request $request): LengthAwarePaginator
    {
        $sort = filter_var($request['sort_by_date'], FILTER_VALIDATE_BOOLEAN);

        $order_by = $sort ? 'published_at' : 'id';
        $direction = $sort ? 'desc' : 'asc';

        // По хорошему сюда следовало бы добавить некоторую оптимизацию, но я сегодня уже очень утомился
        // Напрмер запрашивать из базы только то что указано в запросе атрибутов
        // И не загружать не используемые связанные данные (authors, image)
        return News::with('authors', 'image')
            ->orderBy($order_by, $direction)
            ->paginate(config('parser.news_on_page'));
    }
}
