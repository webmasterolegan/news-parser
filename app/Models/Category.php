<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
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

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
