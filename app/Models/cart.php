<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts'; 
    
    protected $primaryKey = 'Order_id'; 
    
    protected $fillable = [
        'product_id',
        'product_name',
        'customer_name',
        'quantity',
        'total_price',
    ];    
}