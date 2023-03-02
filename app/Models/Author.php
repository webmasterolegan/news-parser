<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $casts = [
        'name' => 'string',
    ];

    /**
     * Массово назначаемые атрибуты.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Новости автора.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
