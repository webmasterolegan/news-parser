<?php

namespace App\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Events\ConnectionFailed;
use App\Models\ParserRequestLog;

class ParserRequestLogger
{
    /**
     * Handle parser request events.
     */
    public function handleRequestComplete(ResponseReceived $event): void {
        $content_type = $event->response->header('Content-Type');
        // Проверка на текстовое содержимое для корректно сохранения в базу
        $content_body = preg_match('/^text/i', $content_type)
            ? $event->response->body()
            : '(binary data: ' . $content_type . ')';

        // Приводим время выполнения запроса к целым миллисекундам
        $execution_time = round($event->response->transferStats->getTransferTime() * 1000, 0);

        // Сохраняем данные запроса в базу логов парсера
        ParserRequestLog::create([
            'method' => $event->request->method(),
            'url' => $event->request->url(),
            'response_code' => $event->response->status(),
            'response_body' => $content_body,
            'execution_time' => $execution_time,
            'completed_at' => New \DateTime,
        ]);
    }

    public function handleRequestFaild(ConnectionFailed $event): void {
        ParserRequestLog::create([
            'method' => $event->request->method(),
            'url' => $event->request->url(),
            'response_code' => null,
            'response_body' => null,
            'execution_time' => 0,
            'completed_at' => New \DateTime,
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            ResponseReceived::class => 'handleRequestComplete',
            ConnectionFailed::class => 'handleRequestFaild',
        ];
    }
}