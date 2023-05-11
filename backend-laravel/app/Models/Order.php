<?php

namespace App\Models;

use App\Enums\StatusOrder;
use App\Enums\StatusPayment;
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
        'ref',
        'card',
        'status_payment',
    ];

    protected $casts = [
        'status_orders' => StatusOrder::class,
        'status_payment' => StatusPayment::class,
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id')
            ->withPivot(['price', 'sale', 'quantity']);;
    }
}
