<?php

return [
    /*
    |--------------------------------------------------------------------------
    | URL RSS ленты новостей
    |--------------------------------------------------------------------------
    */
    'rss_feed_url' => env('PARSER_RSS_FEED_URL', 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss'),

    /*
    |--------------------------------------------------------------------------
    | Блокировка процессов парсера (разрешен только один процесс, значение true)
    |--------------------------------------------------------------------------
    */
    'lock' => env('PARSER_LOCK_PROCESS', true),

    /*
    |--------------------------------------------------------------------------
    | Количество новостей для постраничной разбивки
    |--------------------------------------------------------------------------
    */
    'news_on_page' => env('PARSER_NEWS_ON_PAGE', 100),

    /*
    |--------------------------------------------------------------------------
    | Ключ кеша для хранения массива ссылок новостей
    |--------------------------------------------------------------------------
    */
    'links_cache_key' => 'isset_news_links',

    /*
    |--------------------------------------------------------------------------
    | Путь для хранения файлов изображений
    |--------------------------------------------------------------------------
    */
    'images_path' => 'images/',

    /*
    |--------------------------------------------------------------------------
    | Домустимые типы изображений для сохранения
    |--------------------------------------------------------------------------
    */
    'images_types' => [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ],

    /*
    |--------------------------------------------------------------------------
    | API News допустимы значения для GET переменной attributes
    |--------------------------------------------------------------------------
    */
    'news_attributes' => [
        'id',
        'title',
        'description',
        'published_at',
    ],
    'news_relations' => [
        'authors',
        'image',
    ],
];