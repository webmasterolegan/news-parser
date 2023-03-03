# News Parser

Сборщик новостных публикаций из RSS
## Основные технологии

**Laravel 10**

**MySQL 8**

### Дополнительные пакеты

Получение данных по HTTP [Guzzle HTTP client](https://laravel.com/docs/10.x/http-client)

Отладка [Laravel Telescope](https://laravel.com/docs/10.x/telescope)

## Описание

Сбор и добавление новостей осуществляется командой:

php artisan news:update

Для автоматической сборки новостей необходимо запустить [планировщик задач Laravel](https://laravel.com/docs/10.x/scheduling#running-the-scheduler). Планировщик будет запускать команду куждую минуту.

Блокировка парсера реализована на уровне планировщика и самого класса сервиса парсера [**App\Services\RssParser**](https://github.com/webmasterolegan/news-parser/blob/master/app/Services/RssParserService.php), по умолчанию масимальное время бля хранения блокировки установлено на 120 секунд, константа **PARSER_LOCK_TIME**.

Логирование запросов парсера реализовано через прослушивание событий [**Guzzle HTTP**](https://laravel.com/docs/10.x/http-client#events) клиента.
По умолчанию логируются все запросы, в базу сохраняются только текстовые данные, в противном случае будет записано значение (binary data: *тип данных*)

Сохранение изображений реализовано через прослушивание события **created** модели **App\Models\Image**.

Слушатель события создания изображений **App\Listeners\ImageCreated** запускается в очереди.

Для корректной работы необходимо активировать работу [очередей](https://laravel.com/docs/10.x/queues#running-the-queue-worker)

## Настройки

**PARSER_RSS_FEED_URL** URL для получения новостной ленты

**PARSER_NEWS_ON_PAGE** Количество записей для постраничной навигации


## Dev

composer install --dev

./vendor/bin/sail up

## API

Получение новостей

*/api/news*

Для сортировки по дате публикации необходимо указать GET переменную **sort_by_date=true**

Пример: */api/news?sort_by_date=true*

Для получения конкретных полей необходимо указать GET переменную **attributes** перечисляя поля через запятую.
Если значение не указано, будут возвращены все поля согласно настройкам **App\Http\Resources\NewsResource**

Пример: */api/news?attributes=id,title,description,published_at,authors,image*
