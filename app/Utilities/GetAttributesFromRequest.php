<?php

namespace App\Utilities;

use Illuminate\Http\Request;

class GetAttributesFromRequest
{
    // Получение запрашиваемых атрибутов из GET запроса
    public static function data(Request $request): ?array
    {
        return $request['attributes'] ? explode(',', $request['attributes']) : null;
    }
}