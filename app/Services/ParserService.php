<?php

namespace App\Services;

use App\Contracts\ParserServiceContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use App\Contracts\ParserContract;

class ParserService implements ParserServiceContract
{
    const PARSER_IN_PROGRESS = 'parser_in_progress'; // Ключ кеша хранения активности парсера (true/false)
    const PARSER_LOCK_TIME = 120; // Максимальное время хранения данных блокировки парсера

    protected bool $lock;

    public function __construct(
        protected ParserContract $parser
    ) {
        $this->lock = config('parser.lock');

        if (!$this->lock) return;
        if ($this->lock && cache(self::PARSER_IN_PROGRESS)) {
            throw new \RuntimeException('Другой процесс парсера всё ещё активен');
        }

        cache([self::PARSER_IN_PROGRESS => true], self::PARSER_LOCK_TIME);
    }

    /**
     * Получение массива новостей по URL из XML документа
     */
    public function getData(string $url): ?Collection
    {
        $response = Http::get($url);
        if (!$response->successful()) return null;

        return $this->parser->extract(body: $response->body());
    }

    public function __destruct()
    {
        if (!$this->lock) return;
        cache([self::PARSER_IN_PROGRESS => false], self::PARSER_LOCK_TIME);
    }
}