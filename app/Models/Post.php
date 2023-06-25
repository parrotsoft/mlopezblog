<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string title
 * @property string body
 * @property float price
 * @property int category_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'category'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->attributes['price'], 0, ',', '.');
    }
}
