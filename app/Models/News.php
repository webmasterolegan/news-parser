<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    /**
     * Массово назначаемые атрибуты.
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'title',
        'description',
        'category_id',
        'published_at',
    ];

    protected $casts = [
        'link' => 'string',
        'title' => 'string',
        'description' => 'string',
        'published_at' => 'datetime',
    ];

     /**
     * Получение связанного изображения.
     */
    public function image(): HasOne
    {
        return $this->hasOne(Image::class);
    }

    /**
     * Авторы новости.
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * Категория новости, основная тематика
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
