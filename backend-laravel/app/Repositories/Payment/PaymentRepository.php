<?php

namespace App\Repositories\Payment;

use App\Models\Payment;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Payment\PaymentRepositoryInterface;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    public function getModel()
    {
        return Payment::class;
    }

    public function getPayments($config)
    {
        return $this->model
            ->orderBy($config['order_by'], $config['mode'])
            ->when($config['search'], function ($q) use ($config) {
                return $q->where($config['search'], "like", "%{$config['key']}%");
            })
            ->paginate($config['page_size'] ?? config('setting.default_page_size'));
    }

    public function findWithRelation(int $id, array $relations)
    {
        return $this->model->find($id)->loadCount($relations);
    }
}
