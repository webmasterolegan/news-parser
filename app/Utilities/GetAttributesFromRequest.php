<?php

namespace App\Utilities;

use Illuminate\Http\Request;

class GetAttributesFromRequest
{
    // Получение запрашиваемых атрибутов из GET запроса
    public static function data(Request $request): ?array
    {
        $get_var = config('parser.get_attributes');
        return $request[$get_var] ? explode(',', $request[$get_var]) : null;
    }
}