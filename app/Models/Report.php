<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $fillable = [
        'receipt_no',
        'customer_name',
        'product_id',
        'product_name',
        'quantity',
        'product_amount',
        'tax_amount',
        'total_amount',
        'grand_total_amount',
        'payment_method',
        'status',
        'receipt_date',
    ];
}
