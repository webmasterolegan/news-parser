<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParserRequestLog extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Массово добавляемые атрибуты.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'method',
        'response_code',
        'response_body',
        'execution_time',
        'completed_at',
    ];

    protected $casts = [
        'url' => 'string',
        'method' => 'string',
        'response_code' => 'integer',
        'execution_time' => 'integer',
        'completed_at' => 'datetime',
    ];
}
