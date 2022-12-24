<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_code',
        'user_id',
        'product_id',
        'total',
        'qty'
    ];
}
