<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Массово назначаемые атрибуты.
     *
     * @var array
     */
    protected $fillable = [
        'news_id',
        'source_url',
        'name',
    ];

    protected $casts = [
        'source_url' => 'string',
        'name' => 'string',
    ];

    /**
     * Получение связанной новости.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
