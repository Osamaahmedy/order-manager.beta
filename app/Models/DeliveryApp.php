<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryApp extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * علاقة مع الطلبات
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
