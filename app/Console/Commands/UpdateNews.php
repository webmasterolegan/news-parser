<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\RequestAndAddLatestNewsContract;
use Illuminate\Contracts\Console\Isolatable;

class UpdateNews extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение и сохранение новостей';

    /**
     * Execute the console command.
     */
    public function handle(RequestAndAddLatestNewsContract $action): void
    {
        $action->handle();
    }
}
