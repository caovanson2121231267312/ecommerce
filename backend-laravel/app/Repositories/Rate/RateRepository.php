<?php

namespace App\Repositories\Rate;

use App\Models\Rate;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Rate\RateRepositoryInterface;

class RateRepository extends BaseRepository implements RateRepositoryInterface
{
    public function getModel()
    {
        return Rate::class;
    }

    public function getCategories($config)
    {
        return $this->model->withCount(['brands', 'products'])
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
