<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'address',
        'total_orders',
        'total_spent',
        'last_order_at',
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'last_order_at' => 'datetime',
    ];
}
