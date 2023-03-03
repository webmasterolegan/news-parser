<?php

namespace App\Models;

use App\Events\NewsCreate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NewsCreate::class,
    ];
}
