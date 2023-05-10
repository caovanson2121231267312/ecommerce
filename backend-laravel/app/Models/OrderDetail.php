<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "quantity",
        "price",
        "sale",
        "product_id",
        "order_id",
    ];
}
