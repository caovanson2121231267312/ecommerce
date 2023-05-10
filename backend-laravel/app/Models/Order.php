<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'payment_id',
        'payload',
        'status',
        'phone',
        'note',
        'quantity',
        'ship',
        'price',
        'sale_price',
        'ip_address',
    ];
}
