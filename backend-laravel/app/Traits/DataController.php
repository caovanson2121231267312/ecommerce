<?php

namespace App\Traits;

trait DataController
{
    public $data = [];

    public $tag;

    public $payment;

    public $order;

    public $orderDetail;

    public $user;
    
    public $role;
    
    public $permission;
    
    public $category;

    public $product;

    public $brand;

    public $productDetail;

    public $rate;

    public function setData($request)
    {
        $this->data = [
            "page" => $request->page,
            "page_size" => $request->page_size,
            "order_by" => $request->order_by ?? "id",
            "mode" => $request->mode ?? "ASC",
            "search" => $request->search ?? null,
            "key" => $request->key ?? null,
        ];
    }
}