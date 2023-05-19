<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusOrder;
use App\Enums\StatusPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnumController extends Controller
{
    public function status_order()
    {
        $order_status = StatusOrder::asArray();
        $payment_status = StatusPayment::asArray();

        $status_order = collect($order_status)->map(function ($key, $value) {
            return [
                'key' => $key,
                'value' => $value,
                'description' => StatusOrder::getDescription($key),
            ];
        })->values();

        $status_payment = collect($payment_status)->map(function ($key, $value) {
            return [
                'key' => $key,
                'value' => $value,
                'description' => StatusPayment::getDescription($key),
            ];
        })->values();

        return response()->json([
            'status_order' => $status_order,
            'status_payment' => $status_payment,
        ], 200);
    }
}
