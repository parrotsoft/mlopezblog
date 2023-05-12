<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $with = [
      'user'
    ];

    protected $fillable = [
        'user_id',
        'order_id',
        'provider',
        'url',
        'amount',
        'currency',
        'status',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'order_id' => 'string',
        'provider' => 'string',
        'url' => 'string',
        'amount' => 'double',
        'currency' => 'string',
        'status' => 'string',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
