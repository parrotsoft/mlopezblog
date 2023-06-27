<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string title
 * @property string body
 * @property float price
 * @property int category_id
 * @property int user_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'title',
        'body',
        'price',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'category_id' => 'integer',
        'title' => 'string',
        'body' => 'string',
        'price' => 'integer',
    ];

    protected $with = [
        'category',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->attributes['price'], 0, ',', '.');
    }
}
