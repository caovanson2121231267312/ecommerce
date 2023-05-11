<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function getOrders($config)
    {
        return $this->model->withCount(['products'])->with('products')
            ->orderBy($config['order_by'], $config['mode'])
            ->when($config['search'], function ($q) use ($config) {
                return $q->where($config['search'], "like", "%{$config['key']}%");
            })
            ->paginate($config['page_size'] ?? config('setting.default_page_size'));
    }

    public function updatePaymentByRef(string $ref, array $data)
    {
        $order = $this->model->where('ref', '=', $ref)->first();
        $order->update($data);
        return $order;
    }

    public function findWithRelation(int $id, array $relations)
    {
        return $this->model->find($id)->loadCount($relations);
    }
}
