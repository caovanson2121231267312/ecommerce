<?php

use App\Enums\StatusOrder;
use App\Enums\StatusPayment;

return [

    StatusOrder::class => [
        StatusOrder::INIT => 'Init',
        StatusOrder::APPROVED => 'Approved',
        StatusOrder::SHIPPING => 'Shipping',
        StatusOrder::COMPLETED => 'Completed',
        StatusOrder::CANCELLED => 'Cancel',
    ],
    StatusPayment::class => [
        StatusPayment::UNPAID => 'Unpaid',
        StatusPayment::PAID => 'Paid',
        StatusPayment::PAYMENT_FAILED => 'Payment Failed',
    ],

];
