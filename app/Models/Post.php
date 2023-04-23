<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'category_id' => 'integer',
        'title' => 'string',
        'body' => 'string'
    ];

    protected $with = [
        'category'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
