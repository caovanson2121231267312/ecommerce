<?php

use App\Enums\StatusOrder;
use App\Enums\StatusPayment;

return [

    StatusOrder::class => [
        StatusOrder::INIT => 'Khởi tạo',
        StatusOrder::APPROVED => 'Đã duyệt',
        StatusOrder::SHIPPING => 'Đang vận chuyển',
        StatusOrder::COMPLETED => 'Đã nhận',
        StatusOrder::CANCELLED => 'Hủy bỏ',
    ],
    StatusPayment::class => [
        StatusPayment::UNPAID => 'Chưa thanh toán',
        StatusPayment::PAID => 'Đã thanh toán',
        StatusPayment::PAYMENT_FAILED => 'Thanh toán lỗi',
    ],

];
